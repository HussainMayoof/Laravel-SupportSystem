@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Update Category</h2>

                    <form action="/categories/{{$category->id}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-floating col-4 mb-4">
                            <input type="text" class="form-control{{$errors->first('name')?' is-invalid':''}}" id="name" name="name" placeholder="" value="{{old('name')??$category->name}}"></input>
                            <label for="name" style="margin-left: 10px">Name</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Submit</button>
                        <a class="btn btn-secondary" href="javascript:history.back()">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection