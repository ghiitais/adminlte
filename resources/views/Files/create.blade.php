@extends('layouts.appnew')
@section('content')
    <div class="content">
        <div class="box">
            <div class="box-header with-border">
                <h5 class="box-title"> Joindre un document de type PDF, Word ou Excel </h5>
            </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
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


        <form method="post" action="{{url('file')}}" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="input-group control-group increment" >
                <input type="file" name="filename[]" class="form-control">

            </div>


            <button type="submit" class="btn btn-primary mb-3" style="margin-top:10px">Envoyer</button>

        </form>
        </div>
    </div>


    <script type="text/javascript">


        $(document).ready(function() {

            $(".btn-success").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click",".btn-danger",function(){
                $(this).parents(".control-group").remove();
            });

        });

    </script>
@endsection