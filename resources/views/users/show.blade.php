@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4 d-inline-block">{{$user->name}}</h2>
                    @if ($user->role == 'user')
                        <button class="btn btn-secondary disabled">User</button>
                    @endif

                    @if ($user->role == 'agent')
                        <button class="btn btn-primary disabled">Agent</button>
                    @endif

                    @if ($user->role == 'admin')
                        <button class="btn btn-info disabled">Admin</button>
                    @endif
                
                    <div class="col mb-4">
                        <h4>Email</h4>
                        <p>{{$user->email}}</p>
                    </div>

                    @if (!$tickets->isEmpty())
                        <div class="col mb-4">
                            <h4>Tickets</h4>
                            <ul>
                                @foreach ($tickets as $ticket)
                                    <li>{{$ticket->title}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($user->role != 'admin')
                        <div class="col mb-4">
                            <h4>Roles</h4>
                            <div class="btn-toolbar">
                                @if ($user->role == 'user')
                                <a class="btn btn-primary me-2" href="javascript:document.getElementById('update-form-agent-{{$user->id}}').submit();">Make Agent</a>

                                <form id="update-form-agent-{{$user->id}}" method="post" action="/users/{{$user->id}}">
                                    @csrf
                                    @method('PUT')
                                    <input name="role" type="hidden" value="agent">
                                </form>
                                @endif
                                <a class="btn btn-success" href="javascript:document.getElementById('update-form-admin-{{$user->id}}').submit();">Make Admin</a>

                                <form id="update-form-admin-{{$user->id}}" method="post" action="/users/{{$user->id}}">
                                    @csrf
                                    @method('PUT')
                                    <input name="role" type="hidden" value="admin">
                                </form>
                            </div>
                        </div>
                    @endif

                    <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection