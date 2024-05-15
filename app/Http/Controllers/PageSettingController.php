<?php

namespace App\Http\Controllers;

use App\DataTables\PageSettingDataTable;
use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class PageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PageSettingDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-page-setting')) {
            return $dataTable->render('page-settings.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('create-page-setting')) {
            return view('page-settings.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (\Auth::user()->can('create-page-setting')) {
            request()->validate([
                'title' => 'required|max:191',
                'type' => 'required',
            ]);
            $pageSetting           =  new  PageSetting();
            $pageSetting->title    = $request->title;
            $pageSetting->type     = $request->type;
            if ($request->type == 'link') {
                $pageSetting->url_type     = $request->url_type;
                $pageSetting->page_url     = filter_var($request->page_url, FILTER_VALIDATE_URL) ? $request->page_url : url($request->page_url);
                $pageSetting->friendly_url = filter_var($request->friendly_url, FILTER_VALIDATE_URL) ? $request->friendly_url : url($request->friendly_url);
            } else {
                $pageSetting->description  = $request->descriptions;
            }
            $pageSetting->save();
            return redirect()->route('page-setting.index')->with('success',  __('Page Setting Created successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('edit-page-setting')) {
            $pageSettings = PageSetting::find($id);
            return view('page-settings.edit', compact('pageSettings'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-page-setting')) {
            request()->validate([
                'page_title' => 'required|max:191',
                'type' => 'required',
            ]);
            $pageSettingUpdate        = PageSetting::where('id', $id)->first();
            $pageSettingUpdate->title = $request->page_title;
            $pageSettingUpdate->type  = $request->type;
            if ($request->type == 'link') {
                $pageSettingUpdate->url_type      = $request->url_type;
                $pageSettingUpdate->page_url      = filter_var($request->page_url, FILTER_VALIDATE_URL) ? $request->page_url : url($request->page_url);
                $pageSettingUpdate->friendly_url  = filter_var($request->friendly_url, FILTER_VALIDATE_URL) ? $request->friendly_url : url($request->friendly_url);
            } else {
                $pageSettingUpdate->description = $request->descriptions;
            }
            $pageSettingUpdate->save();
            return redirect()->route('page-setting.index')->with('success',  __('Page Setting Updated successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('delete-page-setting')) {
            $pageSettingDelete = PageSetting::where('id', $id)->first();
            $pageSettingDelete->delete();
            return redirect()->back()->with('success', __('Page Setting Deleted Successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied'));
        }
    }
}
