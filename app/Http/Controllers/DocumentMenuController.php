<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocumentMenu;
use Illuminate\Http\Request;
use App\Models\DocumentGenrator;

class DocumentMenuController extends Controller
{
    public function index()
    {
        $docMenu = DocumentMenu::all();
        return view('document-menu.index', compact('doc_menu'));
    }

    public function create($docMenuId)
    {
        $documents = DocumentGenrator::find($docMenuId);
        return view('document-menu.create', compact('documents'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|max:191',
        ]);
        $documentId             = $request->document_id;
        $docMenu                = new DocumentMenu();
        $docMenu->title         = $request->title;
        $docMenu->document_id   = $request->document_id;
        $docMenu->parent_id     = 0;
        $docMenu->save();
        return redirect()->route('document.design', $documentId)->with('success', __('Menu created successfully.'));
    }


    public function submenuCreate($id, $doc_menu_id)
    {
        $documentMenu    = DocumentMenu::find($id);
        $document         = DocumentGenrator::find($doc_menu_id);
        return view('document-menu.submenu-create', compact('documentMenu', 'document'));
    }

    public function submenuStore(Request $request)
    {
        request()->validate([
            'title' => 'required|max:191',
        ]);
        $documentId             = $request->document_id;
        $docMenu                = new DocumentMenu();
        $docMenu->title         = $request->title;
        $docMenu->document_id   = $request->document_id;
        $docMenu->parent_id     = $request->parent_id;
        $docMenu->save();
        return redirect()->route('document.design', $documentId)->with('success', __('Submenu created successfully.'));
    }

    public function destroy($id)
    {
        $documentMenu  = DocumentMenu::find($id);
        if ($documentMenu ->parent_id == 0) {
            DocumentMenu::where('parent_id', $id)->delete();
        }
        $documentMenu ->delete();
        return redirect()->route('document.index')->with('success', __('Documents deleted successfully.'));
    }

    public function submenuDestroy($id)
    {
        $documentMenu  = DocumentMenu::find($id);
        $documentMenu ->delete();
        return redirect()->route('document.index')->with('success', __('Documents deleted successfully.'));
    }
}
