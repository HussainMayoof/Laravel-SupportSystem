<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->cannot('viewAny', Label::class)) {
            abort(403);
        }

        return view('labels.index', ['labels' => Label::paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->cannot('create', Label::class)) {
            abort(403);
        }

        return view('labels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->cannot('create', Label::class)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'name' => 'required'
        ]);

        Label::create($incomingFields);

        Log::create([
            'title' => 'Label '.$incomingFields['name'].' created',
            'description' => nl2br('Name: '.$incomingFields['name'])
        ]);

        return redirect('labels');
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label)
    {
        if (auth()->user()->cannot('view', $label)) {
            abort(403);
        }

        return view('labels.show', ['label' => $label]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        if (auth()->user()->cannot('update', $label)) {
            abort(403);
        }

        return view('labels.edit', ['label' => $label]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        if (auth()->user()->cannot('update', $label)) {
            abort(403);
        }

        $incomingFields = $request->validate([
            'name' => 'required'
        ]);

        $label->update($incomingFields);

        Log::create([
            'title' => 'Label '.$label->name.' updated',
            'description' => nl2br('Name: '.$incomingFields['name'])
        ]);

        return redirect('labels');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if (auth()->user()->cannot('delete', $label)) {
            abort(403);
        }

        Log::create([
            'title' => 'Label '.$label->name.' deleted',
            'description' => nl2br('Name: '.$label->name)
        ]);

        $label->delete();

        return redirect('labels');
    }
}
