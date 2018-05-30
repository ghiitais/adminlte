@extends('layouts.appnew')
@section('title', 'All Tickets')

@section('content')

<section class="content-header">
    <a href="{{ url('new_ticket') }}" class="btn btn-success mb-3">Ajouter ticket </a>
</section>
<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-ticket"> </i> Tickets </i></h3>
        </div>
        <div class="box-body">
        @if ($tickets->isEmpty())
                        <p>There are currently no tickets.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID </th>
                                <th>Opened by</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th style="text-align:center" colspan="2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td><a href="{{ url('tickets/'. $ticket->ticket_id) }}">
                                            #{{ $ticket->ticket_id }} </a></td>
                                    <td> {{$ticket->user->name}} </td>
                                    <td>
                                        @foreach ($categories as $category)
                                            @if ($category->id === $ticket->category_id)
                                                {{ $category->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                        @if ($ticket->status === 'Open')
                                            <span class="badge bg-green">{{ $ticket->status }}</span>
                                        @else
                                            <span class="badge bg-red">{{ $ticket->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ url('tickets/' . $ticket->ticket_id) }}" class="btn btn-primary">Comment</a>
                                    </td>
                                    <td>
                                        <form action="{{ url('admin/close_ticket/' . $ticket->ticket_id) }}" @if (\Illuminate\Support\Facades\Auth::user()->is_admin != 1) hidden @endif method="POST">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-danger">Close</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $tickets->render() }}
                    @endif
    
        </div>
      </div>
    </section>
@endsection