
@extends('layouts.appnew')

@section('title', 'Managers')

@section('content')
    <div class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> <i class="fa fa-user-circle"> Ajouter comme manager </i> </h3>
            </div>

            <div class="box-body">
                @include('includes.flash')
                @if ($users->isEmpty())
                    <p>Aucun utilisateur n'est enregistré</p>
                @else
                    <table class="table table-bordered">
                        <thead>

                        <tr>
                            <th> Nom </th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>

                                @if($user->is_manager !== 1)
                                    <td>
                                        <form action="{{url('ajouter_manager/'.$user->id)}}" method="post">
                                            {!! csrf_field() !!}
                                            <button class=" btn-info"> <i class="fa fa-plus "></i></button>
                                        </form>

                                    </td>
                                @else
                                    @if($user->is_manager == 1)
                                       <td>
                                        <form action="{{url('remove_manager/' . $user->id)}}" method="post">
                                            {!! csrf_field() !!}
                                            <button class="btn-danger"> <i class="fa fa-trash"></i></button>
                                        </form>
                                       </td>
                                    @endif


                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->render()}}

                @endif
            </div>
        </div>

    </div>
@endsection