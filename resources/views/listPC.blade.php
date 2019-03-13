@extends('layout.PC')
@section('contentPC')
    @foreach($pc as $cate)
        <div class="box-category-home">
            <div class="box-category-header">
                <ul>
                    <li><a href="{{url($table).'/'.$cate->none_name}}"><i class="fab fa-asymmetrik"></i> {{$cate->name}}</a></li>
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