@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">{{$ticket->title}}</h2>
                
                    <div class="col mb-4">
                        <h4>Description</h4>
                        <span>{{$ticket->description}}</span>
                    </div>

                    <div class="col mb-4">
                        <h4>Categories</h4>
                        <ul>
                            @foreach ($ticket->categories as $category)
                                <li>{{$category->name}}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col mb-4">
                        <h4>Labels</h4>
                        <ul>
                            @foreach ($ticket->labels as $label)
                                <li>{{$label->name}}</li>
                            @endforeach
                        </ul>
                    </div>

                    @if (auth()->user()->role == 'admin')
                        <div class="col mb-4">
                            <h4>Assigned Agent</h4>
                            <p>
                                @if (is_null($ticket->agent))
                                    No agent assigned, please edit the ticket to assign an agent to it.
                                @else
                                    {{$ticket->agent->name}}
                                @endif
                            </p>
                        </div>
                    @endif

                    <div class="col mb-4">
                        <h4>Status</h4>
                        <p>
                            @if ($ticket->is_open)
                                Open
                            @else
                                Closed
                            @endif
                        </p>
                    </div>

                    @if (!$images->isEmpty())
                        <div class="col mb-4">
                            <h4>Images</h4>
                            @foreach ($images as $image)
                                <a href="{{$image->path}}"><img src="{{$image->path}}" class="img-thumbnail" style="max-height: 200px"></a>
                            @endforeach
                        </div>
                    @endif

                    @if ((auth()->user()->role == 'agent') OR (auth()->user()->role == 'admin'))
                        <a class="btn btn-primary" href="/tickets/{{$ticket->id}}/edit">Edit</a>
                    @endif

                    <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Comments</h2>

                    <form action="/comments" method="POST">
                        @csrf
                        <div class="form-floating col mb-2">
                            <textarea name="contents" id="contents" class="form-control{{$errors->first('contents')?' is-invalid':''}}" style="height: 75px;" placeholder="Comment"></textarea>
                            <label for="content">Comment</label>

                            @error('contents')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticket->id}}">

                        <button type="submit" class="btn btn-primary mb-4">Comment</button>
                    </form>

                    @foreach ($comments as $comment)
                        <div class="card col-12">
                            <div class="card-body">
                                <p class="fs-6 m-0">{{$comment->user->name}} at {{date_format($comment->created_at, 'H:i, d/m/Y')}}</p>
                                <p class="fs-5 mb-0">{{$comment->contents}}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
@endsection