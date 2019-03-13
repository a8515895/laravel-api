@extends('layout.PC')
@section('contentPC')
    <div class="row w100">
        <div class="col-md-12 main-bg-color">
            <h4 class="w-color">{{$pc->name}}</h4>
        </div>
    </div>
    <div class="row w100" style="padding : 5px;background : #f4f4f4">
        <div class="col-md-3">
            <span style="display : inline-block"><i class="fas fa-bars pointer tab-click activeTab" onclick="clickTab(this,'bar')"></i></span>
            <span class="hidden-xs hidden-sm" style="display : inline-block"><i class="fas fa-list pointer tab-click" onclick="clickTab(this,'list')"></i></span>
        </div>
        <div class="col-md-4" ></div>
        <div class="col-md-3" style="padding : 0">
            <span style="display : inline-block">Sắp xếp theo</span>
            <select id="select-order-by">
                <option value="name asc">Tên (A->Z)</option>
                <option value="name desc">Tên (Z->A)</option>
                <option value="price asc">Giá tăng dần</option>
                <option value="price desc">Giá giảm dần</option>
                <option value="create_at asc">Mới nhất</option>
                <option value="create_at desc">Cũ nhất</option>
            </select>
        </div>
        <div class="col-md-2" style="padding : 0">
            <span style="display : inline-block">Hiển thị</span>
            <select id="select-limit">
                <option value="8">8</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
    <div class="row w100">
        <div class="tab-contain">
            <div class="tab-item activeTab" href="bar">
                @foreach($product as $pro)
                    <div class="col-md-3" style="margin-top : 10px;">
                        <div class="box-category-item">
                            <div class="item-img">
                                <a href="{{url('product').'/'.$pro->none_name}}">
                                    <img class="img-reponsive" src="{{asset('public/img/product').'/'.$pro->img}}" alt="{{$pro->name}}"/>
                                </a>
                            </div>
                            <div class="item-title">
                                <a data-toggle="tooltip" data-placement="top" title="{{$pro->name}}" href="{{url('product').'/'.$pro->none_name}}">{{str_limit($pro->name,20)}}</a>
                            </div>
                            <div class="item-price">
                                <a href="{{url('product').'/'.$pro->none_name}}">{{number_format($pro->price)}}</a>
                            </div>
                            <div class="item-action">
                                <i data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ hàng" class="fas fa-shopping-cart" onclick='addProduct(@json($pro))' style="color : #333;"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="tab-item" href="list">
                @foreach($product as $pro)
                    <div class="row">
                        <div class="col-md-12 pdl0 pdr0" style="height : 270px;background : #f4f4f4;margin-top : 10px">
                            <div class="row pdl0 pdr0 h100">
                                <div class="col-md-3" style="padding-top : 5px;padding-bottom : 5px;">
                                    <div class="item-img">
                                        <a href="{{url('product').'/'.$pro->none_name}}">
                                            <img class="img-reponsive img-thumbnail" src="{{asset('public/img/product').'/'.$pro->img}}" alt="{{$pro->name}}"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9 h100">
                                    <div class="row" style="height : 15%">
                                        <div class="col-md-12">
                                            <h4 style="color : #333"><a href="{{url('product').'/'.$pro->none_name}}">{{$pro->name}}</a></h4>
                                        </div>
                                    </div>
                                    <div class="row" style="height : 55%;overflow-x : hidden">
                                        <div class="col-md-12" style="color : #333;">{{$pro->description}}</div>
                                    </div>
                                    <div class="row " style="height : 10%;">
                                        <div class="col-md-12 f18">{{number_format($pro->price)}}</div>
                                    </div>
                                    <div class="row" style="height : 20%;">
                                        <div class="col-md-12">
                                            <div class="h100 f18 b center pointer main-bg-color w-color" style="width : max-content;padding : 10px"><span style="display : block;"><i class="fas fa-cart-plus" ></i> Thêm Vào Giỏ Hàng</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row w100">
                <div class="col-md-12">
                    <div class="pull-right">
                        {{$product->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            let pageLink = $('a.page-link').attr('href');
            if(getUrlParameter('order_name') != null && getUrlParameter('order_name') != ''){
                $("#select-order-by").val(getUrlParameter('order_name')+' '+getUrlParameter('order_type'))
                pageLink+='&'+$.param({order_name : getUrlParameter('order_name'),order_type : getUrlParameter('order_type')});
            }
            if(getUrlParameter('limit') != null && getUrlParameter('limit') != ''){
                $("#select-limit").val(getUrlParameter('limit'));
                pageLink+='&'+$.param({limit : getUrlParameter('limit')});
            }
            $('a.page-link').attr('href',pageLink);            
            $("#select-order-by").on("change",function(){
                let val = $(this).val();
                let val2 = $("#select-limit").val();
                let val3 
                let v=val.split(" ");
                let param=$.param({limit : val2,order_name : v[0],order_type : v[1]});
                window.location.href = "{{url('category').'/'.$pc->none_name}}?"+param;
                return false;
            })
            $("#select-limit").on("change",function(){
                let val = $("#select-order-by").val()
                let val2 = $(this).val();;
                let v=val.split(" ");
                let param=$.param({limit : val2,order_name : v[0],order_type : v[1]});
                window.location.href = "{{url('category').'/'.$pc->none_name}}?"+param;
                return false;
            })
        })
    </script>
@endsection