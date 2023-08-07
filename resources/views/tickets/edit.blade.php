@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Edit Ticket</h2>

                    <form action="/tickets/{{$ticket->id}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-floating col mb-4">
                            <input type="text" class="form-control{{$errors->first('title')?' is-invalid':''}}" id="title" name="title" placeholder="" value="{{old('title') ?? $ticket->title}}"></input>
                            <label for="title" style="margin-left: 10px">Title</label>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating col mb-4">
                            <textarea type="text" class="form-control{{$errors->first('description')?' is-invalid':''}}" id="description" name="description" placeholder="" style="height: 150px">{{old('description') ?? $ticket->description}}</textarea>
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
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="{{$category->id}}" id="categoryCheck{{$category->id}}"{{$ticket->categories->contains($category) ? 'checked' : ''}}>
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
                                    <input class="form-check-input" name="labels[]" type="checkbox" value="{{$label->id}}" id="labelCheck{{$label->id}}"{{$ticket->labels->contains($label) ? 'checked' : ''}}>
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

                        <div class="form-group col mb-4">
                            <label class="control-label" for="priority">Priority</label>
                            <div class="col-md-4">
                              <select id="priority" name="priority" class="form-control{{$errors->first('priority')?' is-invalid':''}}">
                                <option value="0"{{(old('priority')=='0' OR $ticket->priority==0) ? 'selected' : ''}}>Low</option>
                                <option value="1"{{(old('priority')=='1' OR $ticket->priority==1) ? 'selected' : ''}}>Medium</option>
                                <option value="2"{{(old('priority')=='2' OR $ticket->priority==2) ? 'selected' : ''}}>High</option>
                              </select>
                            @error('priority')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>
                        </div>

                       @if (auth()->user()->role == 'admin')
                        <div class="form-floating col-4 mb-4">
                            <input class="form-control{{$errors->first('agent_id')?' is-invalid':''}}" list="agentOptions" id="agentDataList" name="agent_id" value="{{old('agent_id')  ?? $ticket->agent_id}}" placeholder="Type to search">
                                <label for="agent_id" style="margin-left: 10px">Agent ID</label>
                                
                                <datalist id="agentOptions">
                                    @foreach ($agents as $agent)
                                        <option value="{{$agent->id}}">{{$agent->name}}</option>
                                    @endforeach
                                </datalist>
                            @error('agent_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                       @endif

                        <div class="col mb-4">
                            <input type="checkbox" class="btn-check" id="is_open" name="is_open" autocomplete="off"{{!$ticket->is_open ? ' checked' : ''}}>
                            <label class="btn btn-outline-success" for="is_open">Open</label>
                        </div>


                        <button type="submit" class="btn btn-success">Submit</button>
                        <a class="btn btn-secondary" href="javascript:history.back()">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var btn = $("#is_open");
            var label = $("[for='is_open']")
            var toggled = false;
            btn.on("click", function() {
                if(!toggled)
                {
                toggled = true;
                label.text("Closed");
                } else {
                toggled = false;
                label.text("Open");
                }
            });
        });
    </script>
@endsection