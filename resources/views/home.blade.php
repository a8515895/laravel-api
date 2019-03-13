@extends('layout.index')
@section('content')
<div id="carousel-example-generic" class="carousel slide hidden-sm hidden-xs" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="{{asset('public/img/hinh-mau-1.png')}}" alt="Hình mẫu 1" style="height : 400px;margin : auto" height='400px'>
            <div class="carousel-caption">
                Hình mẫu 1
            </div>
        </div>
        <div class="item">
            <img src="{{asset('public/img/hinh-mau-2.png')}}" alt="Hình mẫu 2" style="height : 400px;margin : auto" height='400px'>
            <div class="carousel-caption">
                Hình mẫu 2
            </div>
        </div>
        <div class="item">
            <img src="{{asset('public/img/hinh-mau-3.png')}}" alt="Hình mẫu 3" style="height : 400px;margin : auto" height='400px'>
            <div class="carousel-caption">
                Hình mẫu 3
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
@foreach($category as $cate)
    <div class="box-category-home">
        <div class="box-category-header">
            <ul>
                <li><a href="{{url('category').'/'.$cate->none_name}}"><i class="fab fa-asymmetrik"></i> {{$cate->name}}</a></li>
                @foreach($categoryChild as $cateChild)
                    @if($cateChild->parent == $cate->id)
                        <li><a href="{{url('category').'/'.$cateChild->none_name}}">{{$cateChild->name}}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="box-category-content owl-carousel owl-theme">
        @foreach($product[$cate->id] as $pro)
            <div class="box-category-item">
                <div class="item-img">
                    <a href="{{url('product').'/'.$pro->none_name}}">
                        <img src="{{asset('public/img/product').'/'.$pro->img}}" alt="{{$pro->name}}"/>
                    </a>
                </div>
                <div class="item-title">
                    <a data-toggle="tooltip" data-placement="top" title="{{$pro->name}}" href="{{url('product').'/'.$pro->none_name}}">{{str_limit($pro->name,20)}}</a>
                </div>
                <div class="item-price">
                    <a href="{{url('product').'/'.$pro->none_name}}">{{number_format($pro->price)}}</a>
                </div>
                <div class="item-action">
                    <i data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng" class="fas fa-shopping-cart" onclick='addProduct(@json($pro))'></i>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endforeach
@endsection