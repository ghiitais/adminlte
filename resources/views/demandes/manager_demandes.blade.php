@extends('layouts.appnew')

@section('title', 'Mes demandes')

@section('content')
<section class="content">
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-ticket"> Demandes crées par les collaborateurs </i></h3>
        </div>
        <div class="box-body">
                    @if ($demandes->isEmpty())
                        <p>Aucune demande n'a été crée</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                            @include('includes.flash')
                            <tr>
                                <th> Détails </th>
                                <th>Demandée par</th>
                                <th> Type </th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Crée</th>
                                <th> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($demandes as $demande)
                                <tr>
                                    <td>
                                        <a href="{{url('demandeDetails/'.$demande->demande_id)}}">
                                            Voir détails de la demande
                                        </a>
                                    </td>
                                    <td>{{$demande->user->name}}</td>

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
                                            @else
                                            <span class="badge bg-light-blue">{{$demande->status}}</span>

                                        @endif
                                        @if(str_contains($demande->status, 'Rejetée') )
                                            <a href="{{ url('demandes/' . $demande->demande_id) }}" > <strong> Voir la raison du rejet</strong> </a>
                                        @endif
                                    </td>
                                    <td>{{ $demande->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ \Illuminate\Support\Facades\Auth::user()->is_admin == 1 ? url('admin/accepter/' . $demande->demande_id): url('manager/accepter/' . $demande->demande_id) }}" method="POST">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success" @if($demande->status != "Envoyée aux managers") disabled @endif>Accepter</button>
                                            <!-- Acceptée par les managers, ou refusé par les managers -->
                                        </form>
                                    </td>

                                    <td>
                                        <a href="{{ url('demandes/' . $demande->demande_id) }}" class="{{$demande->status != "Envoyée aux managers" ?" btn btn-danger disabled": " btn btn-danger" }}" role="button">Rejeter</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    @endif
    
        </div>
    </div>
</section>
@endsection