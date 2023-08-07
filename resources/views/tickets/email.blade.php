<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

</head>
<body>
    <div id="app">

        <main class="py-4">
            <div class="container">
                <div class="row">
                    <p>Hello, {{$name}}. A new ticket has been submitted</p>
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
                                        <img src="{{ $message->embed(public_path().$image->path) }}" class="img-thumbnail" style="max-height: 200px">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>



    
