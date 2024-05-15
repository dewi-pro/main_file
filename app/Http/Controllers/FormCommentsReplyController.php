<?php

namespace App\Http\Controllers;

use App\Models\FormCommentsReply;
use Illuminate\Http\Request;

class FormCommentsReplyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'reply' => 'required|max:191',
        ]);
        FormCommentsReply::create([
            'name' => $request->name,
            'reply' => $request->reply,
            'form_id'=> $request->form_id,
            'comment_id' => $request->comment_id,
        ]);
        return redirect()->back();
    }
}
