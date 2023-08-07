@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title">Labels</h2>
                    <a href="/labels/create" class="btn btn-success">New Label</a>

                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Name</th>
                            <th>Number of tickets</th>
                        </thead>

                        <tbody>
                            @foreach ($labels as $label)
                                <tr onclick="window.location.href = '/labels/{{$label->id}}';">
                                    <td>{{$label->name}}</td>
                                    <td>{{count($label->tickets)}}</td>
                                    <td style="text-align: right">
                                        <a class="btn btn-primary" href="/labels/{{$label->id}}/edit">Edit</a>
                                        <a class="btn btn-danger" href="javascript:document.getElementById('delete-form-{{$label->id}}').submit();">Delete</a>

                                        <form id="delete-form-{{$label->id}}" method="post" action="/labels/{{$label->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination">
                        {{ $labels->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection