<?php

namespace App\Http\Controllers;

use App\Models\DocumentGenrator;
use Illuminate\Http\Request;
use App\DataTables\DocumentGenratorDataTable;
use App\Http\Controllers\Controller;
use App\Models\DocumentMenu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class DocumentGenratorController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:manage-document|create-document|edit-document|delete-document', ['only' => ['index']]);
        $this->middleware('permission:create-document', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-document', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-document', ['only' => ['destroy']]);
    }

    public function index(DocumentGenratorDataTable $dataTable)
    {
        return $dataTable->render('document.index');
    }

    public function create()
    {
        $colors = [
            '' => __('Select Color'),
            'info' => 'info',
            'primary' => 'primary',
            'success' => 'success',
            'danger' => 'danger',
            'warning' => 'warning',
            'light' => 'light',
        ];
        return view('document.create', compact('colors'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|max:191',
            'theme' => 'required',
            'document_logo' => 'required|mimes:png,jpg,jpeg,image',
        ]);
        $filename = '';
        if (request()->file('document_logo')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png'];
            $file                 = $request->file('document_logo');
            $extension            = $file->getClientOriginalExtension();
            $check                = in_array($extension, $allowedfileExtension);
            if ($check) {
                $filename = $file->store('document-logo');
            } else {
                return redirect()->route('document.index')->with('failed', __('File type not valid.'));
            }
        }
        $document                    = new DocumentGenrator();
        $document->title             = $request->title;
        $document->created_by        = Auth::user()->id;
        $document->logo              = $filename;
        $document->change_log_status = ($request->change_log_status) ? 'on' : 'off';
        $document->change_log_json   = ($request->change_log_status && $request->change_log_json) ? json_encode($request->change_log_json) : null;
        $document->theme             = $request->theme;
        $document->save();
        return redirect()->route('document.index')->with('success', __('Documents created successfully.'));
    }


    public function edit($id)
    {
        $colors = [
            ''          => __('Select Color'),
            'info'      => 'info',
            'primary'   => 'primary',
            'success'   => 'success',
            'danger'    => 'danger',
            'warning'   => 'warning',
            'light'     => 'light',
        ];
        $document = DocumentGenrator::find($id);
        return view('document.edit', compact('document', 'colors'));
    }

    public function update(Request $request, DocumentGenrator $document)
    {
        request()->validate([
            'title' => 'required|max:191',
            'theme' => 'required',
        ]);
        $filename = $document->logo;
        $emails = $document->logo;
        if ($request->hasFile('document_logo')) {
            request()->validate([
                'document_logo' => 'max:2048|mimes:png,jpg,jpeg,image',
            ]);
            $allowedfileExtension   = ['jpeg', 'jpg', 'png'];
            $file                   = $request->file('document_logo');
            $extension              = $file->getClientOriginalExtension();
            $check                  = in_array($extension, $allowedfileExtension);
            if ($check) {
                $filename = $file->store('document-logo');
            } else {
                return redirect()->route('document.index')->with('failed', __('File type not valid.'));
            }
        }
        $document->title              = $request->title;
        $document->logo               = $filename;
        $document->change_log_status  = ($request->change_log_status) ? 'on' : 'off';
        $document->change_log_json    = ($request->change_log_status && $request->change_log_json) ? json_encode($request->change_log_json) : null;
        $document->theme              = $request->theme;
        $document->save();
        return redirect()->route('document.index')
            ->with('success',  __('Documents updated successfully.'));
    }

    public function destroy($id)
    {
        $document = DocumentGenrator::find($id);
        $document->delete();
        return redirect()->route('document.index')->with('success', __('Documents deleted successfully.'));
    }

    public function documentStatus($id)
    {
        $document = DocumentGenrator::find($id);
        if ($document->status == 1) {
            $document->status = 0;
            $document->save();
            return redirect()->back()->with('success', __('Documents deactiveted successfully.'));
        } else {
            $document->status = 1;
            $document->save();
            return redirect()->back()->with('success', __('Documents activeted successfully.'));
        }
    }

    public function updateDesign(Request $request)
    {
        $documentMenu  = $request->all();
        foreach ($documentMenu['position'] as $key => $item) {
            $documentMenu         = DocumentMenu::where('id', '=', $item)->first();
            $documentMenu->position = $key;
            $documentMenu->save();
        }
    }

    public function design($id)
    {
        $document      = DocumentGenrator::find($id);
        $docMenu      = DocumentMenu::where('document_id', $id)->orderBy('position')->get();
        $menus         = DocumentMenu::find($id);
        return view('document.design', compact('document', 'docMenu', 'menus'));
    }

    public function documentDesignMenu(Request $request, $id)
    {
        $data  = '';
        $documentMenu  = DocumentMenu::orderBy('position')->find($id);
        $data .= '<div id="editorjs" data-json=' . $documentMenu->json . ' data-id=' . $documentMenu->id . '> </div>';
        $id = $documentMenu->id;
        if ($request->html) {
            $documentMenu->html = $request->html;
        } else {
            $documentMenu->html = $data;
        }
        if ($documentMenu) {
            if ($request->value) {
                $documentMenu->json = $request->value;
            }
            $val = $request->value;
            $arr = [];
            if (isset($val)) {
                foreach ($val as $k => $fields) {
                    if ($fields['type'] == "heading" || $fields['type'] == "paragraph") {
                        $arr[$k] = $fields['type'];
                    } else {
                        $arr[$k] = $fields['type'];
                    }
                }
            }
            $documentMenu->save();
            Session::flash('success', __('Documents updated successfully.'));
        } else {
            Session::flash('failed', __('Documents not found.'));
        }
        return response()->json([
            'is_success'    => true,
            'title'         => $documentMenu->title,
            'json'          => $documentMenu->json,
            'html'          => $documentMenu->html,
            'id'            => $id
        ], 200);
    }

    public function documentPublic($slug)
    {
        if ($slug) {
            $menus    = DocumentMenu::where('slug', $slug)->first();
            $document = DocumentGenrator::where('id', $menus->document_id)->first();
            $changeLogJsons = json_decode($document->change_log_json, true);
            $docMenu = DocumentMenu::where('document_id', $document->id)->orderBy('position')->get();
            if ($document->status == 1) {
                $parentArray = [];
                foreach ($docMenu as $key => $value) {
                    $parentArray[] = $value->parent_id;
                }
                if ($document) {
                    return view("document.front.$document->theme.index", compact('document', 'docMenu', 'menus','changeLogJsons', 'parentArray'));
                } else {
                    return redirect()->back()->with('failed', __('Form not found.'));
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function documentPublicMenu(Request $request, $slug, $changelog = '')
    {
        $documentMenu        = DocumentMenu::where('slug', $slug)->first();
        $docMenu             = DocumentMenu::where('document_id', $documentMenu->document_id)->orderBy('position')->get();
        $document             = DocumentGenrator::find($documentMenu->document_id);
        $changeLogJsons     = json_decode($document->change_log_json, true);
        $menus                = DocumentMenu::find($documentMenu->id);
        $parentArray          = [];
        foreach ($docMenu as $key => $value) {
            $parentArray[] = $value->parent_id;
        }
        return view("document.front.$document->theme.index", compact('documentMenu', 'docMenu', 'document', 'menus', 'changeLogJsons', 'parentArray', 'changelog'));
    }

    public function documentPublicSubmenu(Request $request, $slug, $slugmenu)
    {
        $documentMenu          = DocumentMenu::where('slug', $slugmenu)->first();
        $docMenu               = DocumentMenu::where('document_id', $documentMenu->document_id)->orderBy('position')->get();
        $document               = DocumentGenrator::find($documentMenu->document_id);
        $changeLogJsons       = json_decode($document->change_log_json, true);
        $menus                  = DocumentMenu::where('slug', $slug)->first();
        $parentArray = [];
        foreach ($docMenu as $key => $value) {
            $parentArray[] = $value->parent_id;
        }
        return view("document.front.$document->theme.index", compact('documentMenu', 'docMenu', 'document', 'menus', 'changeLogJsons', 'parentArray'));
    }

    public function DocumentGenStatus(Request $request, $id)
    {
        $docGen = DocumentGenrator::find($id);
        $input  = ($request->value == "true") ? 1 : 0;
        if ($docGen) {
            $docGen->status = $input;
            $docGen->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Document status changed successfully.')]);
    }
}
