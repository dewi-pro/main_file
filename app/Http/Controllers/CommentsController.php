<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\CommentsReply;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'comment' => 'required|max:191',
        ]);
        Comments::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'poll_id' => $request->poll_id,
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        $comments = Comments::find($id);
        $comments_reply = CommentsReply::where('comment_id', $id)->get();
        foreach ($comments_reply as $value) {
            $ids = $value->id;
            $reply =  CommentsReply::find($ids);
            $reply->delete();
        }
        $comments->delete();
        return redirect()->back()->with('success', __('Comment deleted successfully.'));
    }
}
