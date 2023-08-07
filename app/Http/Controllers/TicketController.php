<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\File;
use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Mail\NewTicket;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->role == 'admin'){
            if ($request['show'] == 'all') {
                if (isset($request['sort'])) {
                    $tickets = Ticket::filtered($request['sort'])->paginate(5);
                }else {
                    $tickets = Ticket::filtered('statusDsc')->filtered('priorityDsc')->paginate(5);
                }
            }else {
                if (isset($request['sort'])) {
                    $tickets = Ticket::where('agent_id', null)->filtered($request['sort'])->paginate(5);
                }else {
                    $tickets = Ticket::where('agent_id', null)->filtered('priorityDsc')->paginate(5);
                }
            }
        } else if (isset($request['sort'])) {
            $tickets = Ticket::where('user_id', auth()->user()->id)->orWhere('agent_id', auth()->user()->id)->filtered($request['sort'])->paginate(5);
        } else {
            $tickets = Ticket::where('user_id', auth()->user()->id)->orWhere('agent_id', auth()->user()->id)->filtered('statusDsc')->filtered('priorityDsc')->paginate(5);
        }

        $total = count(Ticket::all());
        $open = count(Ticket::where('is_open', 1)->get());
        $closed = count(Ticket::where('is_open', 0)->get());

        return view('tickets.index', ['tickets' => $tickets, 'total' => $total, 'open' => $open, 'closed' => $closed]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->cannot('create', Ticket::class)) {
            abort(403);
        }

        return view('tickets.create', ['categories' => Category::all(), 'labels' => Label::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->cannot('create', Ticket::class)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'categories' => 'required',
            'labels' => 'required',
            'images.*' => 'image|max:20000'
        ]);

        $ticket = Ticket::create([
            'title' => $incomingFields['title'],
            'description' => $incomingFields['description'],
            'priority' => 0,
            'is_open' => 1,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($incomingFields['categories'] as $category) {
            $ticket->categories()->attach($category);
        }

        foreach ($incomingFields['labels'] as $label) {
            $ticket->labels()->attach($label);
        }

        if (!is_null($request->file('images'))) {
            foreach ($request->file('images') as $imagefile) {
                $name = 'images/'.$ticket->id.'/'.Str::random(8);
                $path = Storage::disk('public')->put($name, $imagefile);
                $path = '/storage/'.$path;
                File::create([
                    'path' => $path,
                    'ticket_id' => $ticket->id
                ]);
            }
        }

        Log::create([
            'title' => 'Ticket '.$ticket->title.' created',
            'description' => nl2br('Title: '.$ticket->title.'<br>Description: '.$ticket->description.'<br>Priority: '.$ticket->priority.'<br>User ID: '.$ticket->user_id)
        ]);


        $images = File::where('ticket_id', $ticket->id)->get();
        foreach (User::where('role','admin')->get() as $recipient) {
            Mail::to($recipient->email)->queue(new NewTicket($ticket, $recipient->name,$images));
        }

        return redirect('/tickets');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        if (auth()->user()->cannot('view', $ticket)) {
            abort(403);
        }

        return view('tickets.show', ['ticket' => $ticket, 'images' => File::where('ticket_id', $ticket->id)->get(), 'comments' => Comment::where('ticket_id', $ticket->id)->orderBy('created_at', 'desc')->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        if (auth()->user()->cannot('update', $ticket)) {
            abort(403);
        }

        if (auth()->user()->role == 'admin') {
            return view('tickets.edit', ['ticket' => $ticket, 'categories' => Category::all(), 'labels' => Label::all(), 'agents' => User::where('role','agent')->get()]);
        }else {
            return view('tickets.edit', ['ticket' => $ticket, 'categories' => Category::all(), 'labels' => Label::all()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        if (auth()->user()->cannot('update', $ticket)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'categories' => 'required',
            'labels' => 'required',
            'priority' => 'required'
        ]);

        $ticket->title = $incomingFields['title'];
        $ticket->description = $incomingFields['description'];
        $ticket->priority = $incomingFields['priority'];

        if (isset($request['is_open'])) {
            if ($request['is_open'] == 'on') {
                $ticket->is_open = 0;
            }
        }

        foreach ($incomingFields['categories'] as $category) {
            $ticket->categories()->attach($category);
        }

        foreach ($incomingFields['labels'] as $label) {
            $ticket->labels()->attach($label);
        }

        if (auth()->user()->role == 'admin') {
            $incomingId = $request->validate([
                'agent_id' => ['required', Rule::exists('users', 'id')]
            ]);

            if (User::where('id',$incomingId['agent_id'])->first()->role != 'agent') {
                return back()->withErrors(['agent_id'=>'User must be an agent']);
            }

            $ticket->agent_id = $incomingId['agent_id'];
        }

        $ticket->save();

        Log::create([
            'title' => 'Ticket '.$ticket->title.' updated',
            'description' => nl2br('Title: '.$ticket->title.'<br>Description: '.$ticket->description.'<br>Priority: '.$ticket->priority.'<br>Open: '.$ticket->is_open.'<br>User ID: '.$ticket->user_id.'<br>Agent ID: '.$ticket->agent_id)
        ]);

        return redirect('/tickets');
    }
}
