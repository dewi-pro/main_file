<?php

namespace App\Http\Controllers;

use App\DataTables\FaqDataTable;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(FaqDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-faqs')) {
            return $dataTable->render('faqs.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-faqs')) {
            return view('faqs.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-faqs')) {
            request()->validate([
                'questions' => 'required',
                'answer' => 'required',
                'order' => 'required|unique:faqs,order,',
            ]);
            Faq::create([
                'questions' => $request->questions,
                'answer' => $request->answer,
                'order' => $request->order,
            ]);
            return redirect()->route('faqs.index')
                ->with('success', __('Faq created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-faqs')) {
            $faq = Faq::find($id);
            $next = Faq::where('id', '>', $faq->id)->first();
            $previous = Faq::where('id', '<', $faq->id)->orderBy('id', 'desc')->first();
            return view('faqs.edit', compact('faq','next','previous'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-faqs')) {
            request()->validate([
                'questions' => 'required',
                'answer' => 'required',
                'order' => 'required|unique:faqs,order,' . $id,
            ]);
            $faq = Faq::find($id);
            $faq->questions = $request->questions;
            $faq->answer = $request->answer;
            $faq->order = $request->order;
            $faq->update();
            return redirect()->route('faqs.index')->with('success', __('Faq updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-faqs')) {
            $faq = Faq::find($id);
            $faq->delete();
            return redirect()->route('faqs.index')->with('success', 'Faq deleted successfully.');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
