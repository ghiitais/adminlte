@extends('layouts.appnew')

@section('title', 'Open Ticket')

@section('content')
<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-ticket"> </i> Open New Ticket </i></h3>
        </div>
        <div class="box-body">
            @include('includes.flash')
            <form role="form" method="POST" action="{{ url('/new_ticket') }}">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="control-label">Title</label>
                            <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="category" class="control-label">Category</label>
                                <select id="category" type="category" class="form-control" name="category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="control-label">Priority</label>
                                <select id="priority" type="" class="form-control" name="priority">
                                    <option value="">Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message" class="control-label">Message</label>
                            <textarea rows="10" id="message" class="form-control" name="message"></textarea>
                            @if ($errors->has('message'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-ticket"></i> Open Ticket
                                </button>
                        </div>
                    </form>
    
        </div>
      </div>
    </section>
@endsection