@extends('layouts.appnew')

@section('vuejs')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('content')
<collaborateurs :services="{{$servicesResult}}" :managers="{{$managers}}"></collaborateurs>
@endsection