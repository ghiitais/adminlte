<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;
use App\Ticket;
use App\Mailers\AppMailer;

class TicketsController extends Controller
{

   /* public function __construct()
    {
        //$this->middleware('auth');
    }*/

    // Show the form to create a new ticket
    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }



    public function store(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "Open",
        ]);

        $ticket->save();
       // $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect()->back()->with("status", "A ticket with ID: #$ticket->ticket_id has been opened.");
    }

// Add new ticket from the mobile app to the DB records


public function addTicket(Request $request){

    $ticket = new Ticket([
        'title'     => $request->title,
        'message'   => $request->message,
        'priority' => $request->priority,
        'user_id'   => $request->user_id,
        'ticket_id' => strtoupper(str_random(10)),
        'category_id'  => $request->category_id,
        'status'    => "Open",
    ]);
    if ($ticket->save()) {
        return response()->json([
            'status'=>'success',

        ]);
    } else {
        return response()->json([
            'status'=>'failed',

        ]);
    }


}
        public function userTickets()
        {
            $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
            $categories = Category::all();

            return view('tickets.user_tickets', compact('tickets', 'categories'));
        }

        // JSON response
    public function index() {
        $tickets = Ticket::with('category', 'user', 'comments.user')->orderBy('created_at', 'desc')->get();
        return $tickets;

    }


    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $category = $ticket->category;
        $comments = $ticket->comments;

        return view('tickets.show', compact('ticket', 'category', 'comments'));
    }

    public function showAll(){
        $tickets = Ticket::paginate(7);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function close($ticket_id, AppMailer $mailer){
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $ticket->status = 'Closed';

        $ticket->save();
        $ticketOwner = $ticket->user;

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

        return redirect()->back()->with("status", "The ticket has been closed.");
    }
}
