<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use App\Comment;
use App\Mailers\AppMailer;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{
    public function postComment(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'comment'   => 'required'
        ]);

        $comment = Comment::create([
            'ticket_id' => $request->input('ticket_id'),
            'user_id'   => Auth::user()->id,
            'comment'   => $request->input('comment'),
        ]);

        // send mail if the user commenting is not the ticket owner
       /* if ($comment->ticket->user->id !== Auth::user()->id) {
            $mailer->sendTicketComments($comment->ticket->user, Auth::user(), $comment->ticket, $comment);
        }*/

        return redirect()->back()->with("status", "Your comment has been submitted.");

    }
public function addComment(Request $request, $ticket_id){

        $comment = new Comment([
            'ticket_id' => $ticket_id,
            'comment' => $request->comment,
            'user_id' => $request->user_id

        ]);


    if ($comment->save()) {
        return response()->json([
            'status'=>'success',
            'comment'=>$request->comment,
            'user'=>User::select('name','email', 'avatar')->where('id', $request->user_id)->first(),
            'created_at'=>$comment->created_at->format('Y-m-d\TH:i:s')
        ]);
    } else {
        return response()->json([
            'status'=>'failed',

        ]);
    }
}
}
