@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{$log->title}}</h2>
                
                    <div class="col mb-4">
                        <h4>Description</h4>
                        <span>{!!$log->description!!}</span>
                    </div>

                    <div class="col mb-4">
                        <h4>Log Created At</h4>
                        <span>{{$log->time}}</span>
                    </div>

                    <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection