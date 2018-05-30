@extends('layouts.appnew')

@section('title', 'Mes demandes')

@section('content')
<section class="content-header">
      <h1>
      <i class="fa fa-ticket"></i>Demandes crées par les collaborateurs
      </h1>
</section>
<section class="content">
    <div class="row">
    <div class="col-md-12">
        @include('includes.flash')  
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="{{url('assistante/demandes_active')}}">Demandes actives</a></li>
              <li class="active"><a href="{{url('assistante/demandes_inactive')}}">Demandes completées</a></li>      
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
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
                                        <td>
                                            @if($demande->status == "En attente")
                                            <form action="{{ url('assistante/forward/' . $demande->demande_id) }}" method="POST">
                                                <select multiple required id="manager" class="form-control" name="manager">
                                                    <option disabled selected> -- Selectionner un manager -- </option>
                                                    @foreach($managers as $manager)
                                                        <option  value="{{$manager->id}}">{{$manager->name}} </option>
                                                    @endforeach
                                                </select>
                                                {!! csrf_field() !!}
                                                <button type="submit" class="btn btn-info" @if($demande->status != "En attente" ) hidden  @endif> Envoyer au manager</button>
                                            @endif
                                                <span class="badge bg-green" >
                                                    @if($demande->status != "En attente" )
                                                    Envoyée à @foreach($demande->managers as $manager)

                                                            {{$manager->name}}
                                                        @endforeach

                                                    @endif  </span>
                                            </form>
                                        </td>

                                    </tr>

                            @endforeach


                            </tbody>
                        </table>
                        {{ $demandes->render()}}

              </div>
            </div>
          </div>
        </div>
    </div>
</section>
@endsection