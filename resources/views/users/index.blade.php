@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-12">
                <div class="card-body">
                    <h2 class="card-title">Users</h2>
                    
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Number of Tickets</th>
                            <th>Role</th>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr onclick="window.location.href = '/users/{{$user->id}}';">
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role == 'agent' ? count($user->ticketsAgent) : count($user->ticketsUser)}}</td>
                                    <td>{{str()->title($user->role)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="pagination">
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection