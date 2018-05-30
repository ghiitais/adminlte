@extends('layouts.appnew')

@section('content')
    
<section class="content-header">
      <h1>
      Profil de {{ $user->name }}
      </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="/uploads/avatars/{{ $user->avatar }}" alt="User profile picture">

              <h3 class="profile-username text-center">{{ $user->name }}</h3>
              <form enctype="multipart/form-data" action="/profile" method="POST">
              {{ csrf_field() }}
              <label class="text-center"> <strong> Modifier l'image de profil </strong></label> <br>
              <input type="file" name="avatar">
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">
                @include('includes.flash')
                <div class="form-group">
                  <label for="inputEmail4">Post</label>
                  <input type="text" class="form-control" id="inputEmail4" value="{{ Auth::user()->post }}" placeholder="Post actuel" name="post">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Adresse</label>
                    <input type="text" class="form-control" id="inputAddress" value="{{ Auth::user()->adresse }}" name="adresse" placeholder="1234 Main St">
                </div>
                <div class="form-group">
                    <label for="inputCity">Date de naissance</label>
                    <input  type="date" class="form-control" id="inputCity"  value="{{ Auth::user()->date_naissance }}" name="date_naissance">
                </div>
                <div class="form-group">
                    <label for="inputState">Service</label>
                    <select id="inputState" class="form-control" name="service">
                        @foreach($services as $service)
                            <option value="{{$service->id}}">{{$service->nom}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputZip">Telephone</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->telephone }}" id="inputZip" name="telephone">
                </div>
                <input type="submit" class=" btn btn-primary">
                </form>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection

