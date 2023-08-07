@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title">Tickets</h2>

                    @if (auth()->user()->role == 'admin') 
                        <p>Total Tickets: {{$total}} | Open Tickets: {{$open}} | Closed Tickets: {{$closed}}</p>
                        <a href="{{app('request')->input('show') == 'all' ? '/tickets' : '/tickets?show=all'}}" class="btn btn-primary mb-2">{{app('request')->input('show') == 'all' ? 'Show Unassigned' : 'Show All'}}</a>
                        <p><strong>{{app('request')->input('show') == 'all' ? 'All Tickets: ' : 'Unassigned Tickets'}}</strong></p>
                    @endif

                    @if (auth()->user()->role == 'user') 
                        <a href="/tickets/create" class="btn btn-success mb-4">New Ticket</a>
                    @endif

                    <form action="/tickets" method="POST">
                        @csrf
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Sort By
                            </button>
                            <ul class="dropdown-menu">
                              <li class="dropdown-item">Status <a style="all:unset !important;" href="?sort=statusAsc&show={{app('request')->input('show')}}">&#9650;</a> <a style="all:unset !important;" href="?sort=statusDsc&show={{app('request')->input('show')}}">&#9660;</a></li>
                              <li class="dropdown-item">Priority <a style="all:unset !important;" href="?sort=priorityAsc&show={{app('request')->input('show')}}">&#9650;</a> <a style="all:unset !important;" href="?sort=priorityDsc&show={{app('request')->input('show')}}">&#9660;</a></li>
                            </ul>
                          </div>
                    </form>

                    <table class="table table-striped table-hover">
                        
                        <thead>
                            <th>Ticket Name</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Categories</th>
                            <th>Status</th>
                        </thead>

                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr onclick="window.location.href = '/tickets/{{$ticket->id}}';">
                                    <td>{{$ticket->title}}</td>
                                    <td>{{$ticket->description}}</td>
                                    <td>{{$ticket->importance}}</td>
                                    <td>
                                        @foreach ($ticket->categories as $category)
                                            [{{$category->name}}]
                                        @endforeach  
                                    </td>
                                    <td>{{$ticket->status}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $tickets->appends(['sort' => app('request')->input('sort'), 'show' => app('request')->input('show')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection