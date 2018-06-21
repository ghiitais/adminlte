@extends('layouts.appnew')
@section('content')
    <div class="content">
        <div class="box">
            <div class="box-header with-border">
                <h5 class="box-title"> Ajouter un évènement </h5>
            </div>
            <div class="box-body">
                @include('includes.flash')
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="upload_event" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" name="title" class="form-control" placeholder="Titre de l'évènement" required >
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" name="description" class="form-control" placeholder="Description" required> </textarea>
                    </div>
                    <div class="form-inline">
                    <div class="form-group">
                        <div class="col-md-4 mb-3">
                            <label>Date du début</label>
                            <input type="date" class="form-control" name="dayStart" placeholder="Premier jour de l'évènement" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Heure du début</label>
                            <input type="time" class="form-control" name="timeStart" placeholder="Heure de début de l'évènement" required>
                        </div>
                    </div>

                    </div>

                    <div class="form-inline">
                    <div class="form-group">
                        <div class="col-md-4 mb-3">
                            <label>Date de fin</label>
                            <input type="date" class="form-control" name="dayEnd" placeholder="Dernier jour de l'évènement" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Heure de fin</label>
                            <input type="time" class="form-control" name="timeEnd" placeholder="Heure de fin de l'évènement" >
                        </div>
                    </div>
                    </div>
                </br>
                    <div class="custom-file">

                    <label>Ajouter une photo</label>

                        <input type="file" class="custom-file-input form-control" name="image" required/>

                    <br />
                    <input type="submit" class="btn btn-primary" value="Envoyer" />
                    </div>

                </form>
            </div>

        </div>
    </div>
    </div>



@endsection