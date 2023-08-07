@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title">Categories</h2>
                    <a class="btn btn-success my-2" href="/categories/create">New Category</a>
                    <table class="table table-striped table-hover">
                        <thead>
                            <th>Name</th>
                            <th>Number of tickets</th>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr onclick="window.location.href = '/categories/{{$category->id}}';">
                                    <td>{{$category->name}}</td>
                                    <td>{{count($category->tickets)}}</td>
                                    <td style="text-align: right">
                                        <a class="btn btn-primary" href="/categories/{{$category->id}}/edit">Edit</a>
                                        <a class="btn btn-danger" href="javascript:document.getElementById('delete-form-{{$category->id}}').submit();">Delete</a>

                                        <form id="delete-form-{{$category->id}}" method="post" action="/categories/{{$category->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection