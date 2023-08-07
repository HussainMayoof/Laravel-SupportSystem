<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->cannot('viewAny', Log::class)) {
            abort(403);
        }

        return view('logs.index', ['logs' => Log::paginate(5)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Log $log)
    {
        if (auth()->user()->cannot('view', $log)) {
            abort(403);
        }

        return view('logs.show', ['log' => $log]);
    }

}
