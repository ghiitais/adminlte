@extends('layouts.appnew')
@section('content')
    <div class="content">
        <div class="box">
            <div class="box-header with-border">
                <h5 class="box-title"> Qu'est ce que vous voulez vendre aux collaborateurs? </h5>
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
                    <form action="/multiuploads" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>Nom du produit</label>
                            <input type="text" name="name" class="form-control" placeholder="Nom" >
                        </div>
                        <input type="hidden" type="text" name="user_id" class="form-control" placeholder="Nom" value={{\Illuminate\Support\Facades\Auth::user()->id}} >
                        <div class="form-group">
                            <label>Prix</label>
                            <input type="text" name="price" class="form-control" placeholder="Prix" >
                        </div>
                        <div class="form-group">
                            <label>Détails</label>
                            <input type="text" name="details" class="form-control" placeholder="Détails.." >
                        </div>

                        <label>Photos (Vous pouvez selectionner multiples)</label>
                        <br />

                        <input type="file" class="form-control" name="photos[]" multiple />

                        <br />

                        <input type="submit" class="btn btn-primary" value="Envoyer" />

                    </form>
            </div>

        </div>
        </div>
    </div>



@endsection