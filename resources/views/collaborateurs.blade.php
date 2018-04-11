@extends('layouts.app')

@section('content')
<collaborateurs :services="{{$servicesResult}}" :managers="{{$managers}}"></collaborateurs>
@endsection