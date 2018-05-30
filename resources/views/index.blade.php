@extends('layouts.appnew')

@section('vuejs')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('content')
     <router-view name="articlesIndex"></router-view>
        <router-view></router-view>
@endsection