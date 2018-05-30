@extends('layouts.appnew')

@section('title', $ticket->title)

@section('content')


<section class="content">

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">#{{ $ticket->ticket_id }} - {{ $ticket->title }}</h3>
  </div>
  <div class="box-body">
        @include('includes.flash')
        <p>{{ $ticket->message }}</p>
        <p>Category: {{ $category->name }}</p>
        <p>
            @if ($ticket->status === 'Open')
                Status: <span class="badge bg-green">{{ $ticket->status }}</span>
            @else
                Status: <span class="badge bg-red">{{ $ticket->status }}</span>
            @endif
        </p>
        <p>Created on: {{ $ticket->created_at->diffForHumans() }}</p>    
        <p><h3>Commentaires</h3></p>

        @foreach ($comments as $comment)
            @if($ticket->user->id === $comment->user_id)
            <div class="box box-primary">
            @else
            <div class="box box-success">
            @endif
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $comment->user->name }}
                    <span class="pull-right">{{ $comment->created_at->diffForHumans() }}</span></h3>
                </div>
                <div class="box-body">
                    {{ $comment->comment }}
                </div>
            </div>
        @endforeach


        <form action="{{ url('comment') }}" method="POST" class="form">
                        {!! csrf_field() !!}

                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                            <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                            @if ($errors->has('comment'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('comment') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
  </div>
  
</div>

</section>


@endsection