@extends('layouts.appnew')

@section('title', 'Mes demandes')

@section('content')
<section class="content-header">
    <a href="{{ url('creer_demande') }}" class="btn btn-success mb-3">Créer une demande </a>
</section>
<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-ticket"> Mes demandes </i></h3>
        </div>
        <div class="box-body">
                    @if ($demandes->isEmpty())
                        <p>Vous n'avez aucune demande en cours, créez une par <a href="{{url('creer_demande')}}">ici.</a></p>
                    @else
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID </th>
                                <th>Type </th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Crée</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($demandes as $demande)
                                <tr>
                                    <td>
                                        <a href="{{url('demandeDetails/'.$demande->demande_id)}}" >
                                            #{{ $demande->demande_id }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($demande->type === 'conge')
                                            <strong> Demande de congé</strong>
                                        @endif
                                    </td>
                                    <td>

                                        @if ($demande->priority === 'high')
                                            <span class="badge bg-red">Urgente</span>
                                        @else
                                            <span class="badge bg-light-blue">Normale</span>
                                        @endif

                                    </td>
                                    <td>
                                        @if(str_contains($demande->status, 'Acceptée'))
                                            <span class="badge bg-green">{{ $demande->status }}</span>
                                        @elseif (str_contains($demande->status, 'Rejetée'))
                                            <span class="badge bg-red">{{ $demande->status }}</span>
                                        @elseif ($demande->status == "En attente")
                                            <span class="badge bg-yellow">{{ $demande->status }}</span>
                                            @else
                                            <span class="badge bg-light-blue">{{ $demande->status }}</span>

                                        @endif

                                        @if(str_contains($demande->status, 'Rejetée'))
                                            <a href="{{ url('demandes/' . $demande->demande_id) }}" > <strong> Voir la raison du rejet</strong> </a>
                                            @endif
                                    </td>
                                    <td>{{ $demande->created_at->diffForHumans() }}</td>
                                    <td> <form action="{{url('delete/' . $demande->id)}}" method="post">
                                            {!! csrf_field() !!}
                                            <button class="btn btn-danger"> <i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $demandes->render() }}
                    @endif
        </div>
        
      </div>
</section>
@endsection