@extends('layouts.appnew')

@section('title', 'Ouvrir Demande')

@section('content')
<section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Nouvelle demande</h3>
        </div>
        <div class="box-body">
            @include('includes.flash')
            <form  role="form" method="POST" action="{{ url('/new_demande') }}">
                <div class="form-group">
                    <label for="type">Type de la demande:</label>
                    <select required id="type" name="type" class="form-control">
                        <option value="">Selectionner un type</option>
                        <option value="conge"> Demande de congé </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="priority">Priorité de la demande: </label>
                    <select required id="priority" class="form-control" name="priority">
                        <option selected disabled>Selectionner une priorité</option>
                        <option value="high">Urgente</option>
                        <option value="low">Normale</option>
                    </select>
                </div>
                <div id="conge" style="display:none">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inputPrenom4">Nom et Prenom</label>
                            <input disabled value="{{\Illuminate\Support\Facades\Auth::user()->name}}" type="text" class="form-control" id="inputPrenom4" placeholder="Prenom">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Date de la demande</label>
                            <input disabled value="{{date("d/m/y")}}" class="form-control" id="inputCity">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="firstDay">1er jour ouvré <strong>DU:</strong></label>
                            <input required type="date" name="firstDay" class="form-control" id="firstDay">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lastDay">Dernier jour ouvré <strong>AU:</strong></label>
                            <input required type="date" name="lastDay" class="form-control" id="lastDay">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="arriveOn">Retour <strong>LE:</strong></label>
                            <input required type="date" name="arriveOn" class="form-control" id="arriveOn">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="totalDays">Nombre total de jours ouvrés</label>
                            <input required type="text" name="totalDays" class="form-control" id="totalDays">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="congeType">Type du congé</label>
                            <select required name="congeType" id="congeType" class="form-control">
                                <option selected disabled>Choisissez un type</option>
                                <option value="Payé">Payé</option>
                                <option value="Sans solde">Sans solde</option>
                                <option value="Exceptionnel">Exceptionnel</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-paper-plane "></i> Envoyer la demande </button>
                        
                    </div>
                </div>

                </form>
                    
        </div>
        
      </div>
</section>


@endsection

@section('script')
<script>
        $(function() {
            $('#type').change(function(){
                var x = document.getElementById($('#type').val());
                if (x.style.display === "none") {
                    x.style.display = "block";
                }
            });
        });
    </script>


@endsection