@extends('layouts.app')
@section('content')
    <div class="container">
        @include('includes.flash')
        <div class="card">
            <div class="card-header">
                Ajouter manager
            </div>
            <div class="card-body">
                <h6 class="card-title">Selectionner les utilisateurs à ajouter comme managers</h6>
                <form action="{{url('ajouter_managers')}}" method="post">
                @foreach($users as $user)
                    <div class="form-check" >
                       <div class="form-group" >
                        <input type="checkbox" id="coding" name="user[]" value={{$user->id}} @if($user->is_manager == 1) checked @endif>
                        <label for="user">{{$user->name}}</label>

                        @if($user->is_manager == 1)
                            <form action="{{url('remove_manager/' . $user->id)}}" method="post">
                            {!! csrf_field() !!}
                            <button class="btn-danger"> <i class="fa fa-trash"></i></button>
                        </form>
                        @endif
                       </div>
                    </div>

                    @endforeach

                   {!! csrf_field() !!}
                   <button class="btn btn-primary">Valider</button>
               </form>

            </div>
            {{ $users->render()}}
        </div>

    </div>


    @endsection