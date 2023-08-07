@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{$label->name}}</h2>
                
                    <div class="col mb-4">
                        <h4>Tickets with this label</h4>
                        <ul>
                            @foreach ($label->tickets as $ticket)
                                <li>{{$ticket->title}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <a class="btn btn-primary" href="/labels/{{$label->id}}/edit">Edit</a>
                    <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection