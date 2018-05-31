@extends('layouts.appnew')
@section('title', 'All Tickets')

@section('content')

<section class="content-header">
    <a href="{{ url('new_ticket') }}" class="btn btn-success mb-3">Ajouter ticket </a>
</section>
<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tags"> </i> Tickets </i> </h3>
        </div>
        <div class="box-body">
        @if ($tickets->isEmpty())
                        <p>Aucun ticket pour le moment.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID </th>
                                <th>Crée par</th>
                                <th>Categorie</th>
                                <th>Titre</th>
                                <th>Statut</th>
                                <th>Crée le</th>
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
                                            <span class="badge bg-green">Ouvert</span>
                                        @else
                                            <span class="badge bg-red">Fermé</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ url('tickets/' . $ticket->ticket_id) }}" class="btn btn-primary">Commenter</a>
                                    </td>
                                    <td>
                                        <form action="{{ url('admin/close_ticket/' . $ticket->ticket_id) }}" @if (\Illuminate\Support\Facades\Auth::user()->is_admin != 1) hidden @endif method="POST">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-danger">Fermer</button>
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