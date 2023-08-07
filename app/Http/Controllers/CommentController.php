<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Ticket;
use App\Models\comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (auth()->user()->cannot('view', Ticket::where('id',$request['ticket_id'])->first())) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'contents' => 'required',
            'ticket_id' => ['required', Rule::exists('tickets', 'id')]
        ]);

        $incomingFields['contents'] = strip_tags($incomingFields['contents']);
        $incomingFields['user_id'] = auth()->user()->id;

        Comment::create($incomingFields);

        Log::create([
            'title' => 'Comment created by '.auth()->user()->name,
            'description' => 'Ticket: '.Ticket::where('id', $incomingFields['ticket_id'])->first()->title.'<br>Contents: '.$incomingFields['contents']
        ]);

        return redirect('tickets/'.$incomingFields['ticket_id']);
    }
}
