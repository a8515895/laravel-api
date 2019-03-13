@extends('layout.index')
@section('content')
    <div class="row">
        <ul>
            <li style="display : inline-block"><a href="{{url('/')}}">Home </a></li>
            <li style="display : inline-block"><a href="{{url($table)}}">>> {{$namePC}}</a></li>
        </ul>
    </div>
    <div class="row w100">
        <div class="col-md-3" style="padding : 0">
            <div class="row w100">
                <div class="col-md-12" style="padding-left : 0">
                    <div class="box-item-product">
                        <div class="box-header">
                            Nhà sản xuất
                        </div>
                        <div class="box-content">
                            <ul>
                                @foreach($producerShare as $producer)
                                    <li>
                                        <a style="line-height : 3" href="{{url('producer').'/'.$producer->none_name}}">{{$producer->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row w100">
                <div class="col-md-12" style="padding-left : 0">
                    <div class="box-item-product">
                        <div class="box-header">
                            Chủ đề
                        </div>
                        <div class="box-content">
                            <ul>
                                @foreach($categoryShare as $producer)
                                    <li>
                                        <a style="line-height : 3" href="{{url('producer').'/'.$producer->none_name}}">{{$producer->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row w100" style="margin-top : 10px">
                <div class="col-md-12" style="padding-left : 0">
                    <div class="box-item-product">
                        <div class="box-header">
                            Mới cập nhật
                        </div>
                        <div class="box-content">
                            <ul>
                                @foreach($newProduct as $pro)
                                    <li>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="img hidden-xs hidden-sm">
                                                    <a href="{{url('product/').'/'.$pro->none_name}}">
                                                        <img class="img-responsive img-thumbnail" src="{{asset('public/img/product').'/'.$pro->img}}" alt="{{$pro->name}}" width="100%"/>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <a href="{{url('product/').'/'.$pro->none_name}}">{{$pro->name}}</a>
                                                <a href="{{url('product/').'/'.$pro->none_name}}" style="color : red;font-weight : bold">{{number_format($pro->price)}} VND</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9" style="padding-right : 0">
            @yield('contentPC')
        </div>
    </div>
@endsection