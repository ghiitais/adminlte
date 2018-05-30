@extends('layouts.appnew')

@section('title', $demande->demande_id)

@section('content')

<section class="content">

<!-- Default box -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-arrow-circle-left"></i> <a href="{{\Illuminate\Support\Facades\Auth::user()->is_admin == 1 ? url('admin/demandes'): url('mes_demandes') }}">  Retour </a>
                    #{{ $demande->demande_id }} - Crée par <strong> {{$demande->user->name}}</strong></h3>

    
  </div>
  <div class="box-body">
    @include('includes.flash')
    <p>Type : <strong> Demande de {{ $demande->type }} </strong></p>
    <p>
        @if(str_contains($demande->status, 'Acceptée'))
            <span class="badge bg-green">{{ $demande->status }}</span>
        @elseif (str_contains($demande->status, 'Rejetée'))
            <span class="badge bg-red">{{ $demande->status }}</span>
        @elseif ($demande->status == "En attente")
            <span class="badge bg-yellow">{{ $demande->status }}</span>

        @endif
    </p>
    <p>Crée : {{ $demande->created_at->diffForHumans() }}</p>
    <h3>Raison du rejet</h3>

                    @if(!empty($raisons) )
                        @foreach($raisons as $raison)
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <strong> Raison du rejet de la demande #{{$demande->demande_id}} </strong></h3>
                            </div>
                            <div class="box-body">
                                {{ $raison->message }}
                            </div>
                        </div>
                        @endforeach



                    <div class="comment-form">
                        <form action="{{ \Illuminate\Support\Facades\Auth::user()->is_admin == 1 ? url('admin/rejeter/' . $demande->demande_id): url('manager/rejeter/' . $demande->demande_id) }}" method="POST" class="form">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <textarea rows="10" id="message" class="form-control" name="message"></textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" >Submit</button>
                            </div>
                        </form>
                    </div>
                    @endif
                       @if($demande->status == "Rejetée par le manager" && \Illuminate\Support\Facades\Auth::user()->is_admin == 1)
                          <form action="{{url('admin/accepter/' . $demande->demande_id)}}" method="post">
                              <button class="btn btn-success mt-3" >Accepter</button>
                              {!! csrf_field() !!}
                          </form>

                        <form action="{{url('admin/rejeterDef/' . $demande->demande_id)}}" method="post">
                            <button class="btn btn-danger mt-3" >Rejeter</button>
                            {!! csrf_field() !!}
                        </form>
                           @endif

</div>
  
</div>

</section>
@endsection