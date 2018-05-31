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
                    {!! Form::model($item,["files"=>true,"method"=>"PATCH","class"=>"form-horizontal","action"=> ['MarketController@update',$item->id]]) !!}
                      
                        
                        {!! Form::label('name',"Nom du produit",["class"=>"control-label","id"=>"Label_Id"]) !!}
                        <br>    
                        {!! Form::text('name',null,["class"=>"form-control","required"=>"true","placeholder"=>"Nom"]) !!}
                        
                    
                        <br>
                        {!! Form::label('price',"Prix",["class"=>"control-label","id"=>"Label_Id"]) !!}
                        <br>
                        {!! Form::text('price',null,["class"=>"form-control","required"=>"true","placeholder"=>"Prix"]) !!}
                        
                        <br />
                        {!! Form::label('details',"Détails",["class"=>"control-label","id"=>"Label_Id"]) !!}
                        <br/>
                        {!! Form::text('details',null,["class"=>"form-control","required"=>"true","placeholder"=>"Détails.."]) !!}
                        
                        <br/>

                        <label>Photos (Vous pouvez selectionner multiples)</label>
                        <br />

                        <input type="file" class="form-control" name="photos[]" multiple />

                        <br />

                        <input type="submit" class="btn btn-primary" value="Envoyer" />
                        
                    {!! Form::close() !!}
            </div>

        </div>
        </div>
    



@endsection