<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', ['users' => User::paginate(5)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user->role == 'agent') {
            return view('users.show', ['user' => $user, 'tickets' => $user->ticketsAgent]);
        } else if ($user->role == 'user') {
            return view('users.show', ['user' => $user, 'tickets' => $user->ticketsUser]);
        } else {
            return view('users.show', ['user' => $user, 'tickets' => new Collection]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $role = $request['role'];

        if ($role == 'admin') {
            if ($user->role != 'admin'){
                foreach ($user->ticketsAgent as $ticket) {
                    $ticket->delete();
                }

                foreach ($user->ticketsUser as $ticket) {
                    $ticket->delete();
                }

                $user->role = 'admin';
                $user->save();

                Log::create([
                    'title' => $user->name.' updated',
                    'description' => 'Role: Admin'
                ]);

                return redirect('users');
            }
        }

        if ($role == 'agent') {
            if ($user->role != 'agent'){
                foreach ($user->ticketsUser as $ticket) {
                    $ticket->delete();
                }

                foreach ($user->ticketsAgent as $ticket) {
                    $ticket->agent_id = null;
                }

                $user->role = 'agent';
                $user->save();

                Log::create([
                    'title' => $user->name.' updated',
                    'description' => 'Role: Agent'
                ]);

                return redirect('users');
            }
        }

        return redirect('users');
    }
}
