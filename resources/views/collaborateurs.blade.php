@extends('layouts.app')

@section('content')
<collaborateurs :services="{{$servicesResult}}"></collaborateurs>
@endsection