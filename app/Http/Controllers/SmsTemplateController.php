<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\SmsTemplateDataTable;
use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;

class SmsTemplateController extends Controller
{
    public function index(SmsTemplateDataTable $dataTable)
    {
        return $dataTable->render('sms-template.index');
    }

    public function edit($id)
    {
        $smsTemplate = SmsTemplate::find($id);
        return view('sms-template.edit', compact('smsTemplate'));
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'event' => 'required',
            'template' => 'required',
        ]);
        
        $input = $request->all();
        $smsTemplate = SmsTemplate::find($id);
        $smsTemplate->update($input);
        return redirect()->route('sms-template.index')->with('success', __('Sms template updated successfully.'));
    }
}

