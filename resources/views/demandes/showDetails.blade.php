@extends('layouts.appnew')
@section('content')

<section class="content">
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Demande <strong> #{{$demande->demande_id}} </strong>par <strong> {{$demande->user->name}}</strong></h3>
        </div>
        <div class="box-body">
            @include('includes.flash')
            <form role="form" method="POST" action="{{ url('/new_demande') }}">
                <div class="form-group">
                    <label for="type" class="control-label">Type de la demande:</label>
                    <select required id="type" name="type" class="form-control">
                        <option selected disabled value="{{$demande->type}}"> @if( $demande->type == "conge" ) Demande de congé  @endif </option>
                    </select>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputPrenom4">Nom et Prenom</label>
                        <input disabled value="{{$demande->user->name}}" type="text" class="form-control" id="inputPrenom4" placeholder="Prenom">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCity">Date de la demande</label>
                        <input disabled value="{{$demande->created_at->format('d-m-y')}}" class="form-control" id="inputCity">
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="firstDay">1er jour ouvré <strong>DU:</strong></label>
                        <input type="date" disabled value="{{$demande->firstDay}}" name="firstDay" class="form-control" id="firstDay">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="lastDay">Dernier jour ouvré <strong>AU:</strong></label>
                        <input type="date" disabled value="{{$demande->lastDay}}" name="lastDay" class="form-control" id="lastDay">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="arriveOn">Retour <strong>LE:</strong></label>
                        <input type="date" disabled value="{{$demande->arriveOn}}" name="arriveOn"  class="form-control" id="arriveOn">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="totalDays">Nombre total de jours ouvrés</label>
                        <input type="text" name="totalDays" disabled value="{{$demande->totalDays}} jours" class="form-control" id="totalDays">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="congeType">Type du congé</label>
                        <select name="congeType" id="congeType" class="form-control">
                            <option selected disabled>{{$demande->congeType}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="priority" class="control-label">Priorité de la demande: </label>
                        
                            <select required id="priority" class="form-control" name="priority">
                                <option selected disabled>@if ($demande->priority == "high") Urgente @else Normale @endif</option>
                            </select>
                        
                    </div>
                </div>






                

                    </form>

        </div>
    </div>
</section>

    @endsection