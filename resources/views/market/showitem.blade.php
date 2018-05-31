@extends('layouts.appnew')
@section('content')

<div class="content">
    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title">{{ $item->name }}</h5>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                        <?php $count =0; ?>
                        @foreach($item->itemDetails as $image)
                            @if($count==0)
                            <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
                            <?php $count++ ?>                        
                            @else
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>                        
                            @endif
                        @endforeach
                        </ol>
                        <div class="carousel-inner">
                        <?php $count =0; ?>
                            @foreach($item->itemDetails as $image)
                                @if($count==0)
                                    <div class="item active">
                                        <img src="/market/{{$image->filename}}" style="height:289px;width:508px">
                                    </div>
                                    <?php $count++ ?>
                                @else
                                    <div class="item">
                                        <img src="/market/{{$image->filename}}" style="height:289px;width:508px">
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                        </a>
                </div>
                </div>
                <div class="col-md-6">
                <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">{{ $item->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p class="lead">Price : {{ $item->price }}</p>
              <p class="lead">Seller : {{ $item->user->name }}</p>
              <p>{{ $item->details }}</p>
            </div>
            <!-- /.box-body -->
          </div>
                
                </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection