@extends('layouts.app')
@section('content')
<div class="container">
@foreach($bp as $blogPosts)
    <h1>{{$bp->title}}</h1>
        @foreach($bp->workflow_transitions() as $transition)
            <h1>{{$transition->getName()}}</h1>
        @endforeach
    @endforeach


</div>
@endsection