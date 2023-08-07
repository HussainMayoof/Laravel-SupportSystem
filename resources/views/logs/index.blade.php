@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title">Logs</h2>

                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Title</th>
                            <th>Time</th>
                        </thead>

                        <tbody>
                            @foreach ($logs as $log)
                                <tr onclick="window.location.href = '/logs/{{$log->id}}';">
                                    <td>{{$log->title}}</td>
                                    <td>{{$log->time}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection