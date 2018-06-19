@extends('layouts.appnew')

@section('title', 'Mes demandes')

@section('content')
    <div class="content">

            <div class="box">
                <div class="box-header with-border">
                   <h3 class="box-title"> <i class="fa fa-files-o"> Fichiers partagés par les collaborateurs </i> </h3>
                </div>

                <div class="box-body">
                    @include('includes.flash')
                    @if ($files->isEmpty())
                        <p>Aucun fichier n'a été crée uploadé</p>
                    @else
                        <table id= "example" class="table table-bordered">
                            <thead>

                            <tr>
                                <th> Nom </th>
                                <th>Créer par</th>
                                <th> Crée le </th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>{{$file->filename}}</td>
                                    <td>{{$file->user->name}}</td>


                                    <td> {{$file->created_at->diffForHumans()}}</td>

                                    @if($file->user->id == \Illuminate\Support\Facades\Auth::user()->id)
                                        <td>
                                            <form action="{{url('deleteFile/' . $file->id)}}" method="post">
                                                {!! csrf_field() !!}
                                                <button class="btn btn-danger"> <i class="fa fa-trash"></i></button>
                                            </form>

                                        </td>
                                    @else

                                        <td> <a href="{{ asset('files/'.$file->filename) }}">  <i class="btn btn-info fa fa-cloud-download"></i> </a> </td>

                                   @endif

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $files->render()}}

                    @endif
                </div>
            </div>

    </div>
@endsection
@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script>

    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
    @endsection