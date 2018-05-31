@extends('layouts.appnew')

@section('title', 'Mes demandes')

@section('style')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content')
<section class="content-header">
      <h1>
      <i class="fa fa-files"></i>Demandes crées par les collaborateurs
      </h1>
</section>

<section class="content">
    <div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="{{url('assistante/demandes_active')}}">Demandes actives</a></li>
              <li class=""><a href="{{url('assistante/demandes_inactive')}}">Demandes completées</a></li>      
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

                                        @endif
                                        @if($demande->status === "Rejetée")
                                            <a href="{{ url('demandes/' . $demande->demande_id) }}" > <strong> Voir la raison du rejet</strong> </a>
                                        @endif
                                    </td>
                                    <td>{{ $demande->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ url('assistante/forward/' . $demande->demande_id) }}" method="POST">
                                            <select multiple size="2" required class="form-control manage" name="managers[]" @if($demande->status != "En attente") hidden  @endif>


                                            @foreach($managers as $manager)
                                           <option  value="{{$manager->id}}"> {{$manager->name}} </option>
                                           @endforeach
                                            </select>
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-info" @if($demande->status != "En attente" ) hidden  @endif> Envoyer au manager</button>
                                            @if($demande->status != "En attente" )<span class="badge badge-pill badge-success" >  Envoyée à {{$demande->manager->name}}  @endif  </span>
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

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script type="text/javascript">
        // $('body').on('DOMNodeInserted', 'select', function () {
        //     $(this).select2({
        //         width : 'resolve',
        //         allowClear: true,
        //     });
        // });
        $('.manage').select2({
                width : 'resolve',
                allowClear: true,
            });


  
    </script>
@endsection