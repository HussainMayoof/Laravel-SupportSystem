@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Create a New Ticket</h2>

                    <form action="/tickets" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-floating col mb-4">
                            <input type="text" class="form-control{{$errors->first('title')?' is-invalid':''}}" id="title" name="title" placeholder="" value="{{old('title')}}"></input>
                            <label for="title" style="margin-left: 10px">Title</label>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating col mb-4">
                            <textarea type="text" class="form-control{{$errors->first('description')?' is-invalid':''}}" id="description" name="description" placeholder="" style="height: 150px">{{old('description')}}</textarea>
                            <label for="description" style="margin-left: 10px">Description</label>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating col mb-4">
                            <h4 class="{{$errors->first('categories')?' is-invalid':''}}">Categories</h4>
                            @foreach ($categories as $category)
                                <div class="form-check-inline">
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="{{$category->id}}" id="categoryCheck{{$category->id}}"{{in_array($category->id,old('categories')??[]) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="categoryCheck{{$category->id}}">
                                    {{$category->name}}
                                    </label>
                                </div>
                            @endforeach
                            @error('categories')
                                <div class="invalid-feedback mb-4">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        
                        
                        <div class="form-floating col mb-4">
                            <h4 class="{{$errors->first('labels')?' is-invalid':''}}">Labels</h4>
                            @foreach ($labels as $label)
                                <div class="form-check-inline">
                                    <input class="form-check-input" name="labels[]" type="checkbox" value="{{$label->id}}" id="labelCheck{{$label->id}}"{{in_array($label->id,old('labels')??[]) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="labelCheck{{$label->id}}">
                                    {{$label->name}}
                                    </label>
                                </div>
                            @endforeach
                            @error('labels')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="images[]" style="margin-left: 10px">Images (Optional)</label>
                            <input type="file" class="form-control{{$errors->first('images.*')?' is-invalid':''}}" id="images[]" name="images[]" multiple/>
                            @error('images.*')
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