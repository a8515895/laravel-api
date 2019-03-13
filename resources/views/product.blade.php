@extends('layout.index')
@section('content')
    <div class="row">
        <ul>
            <li style="display : inline-block"><a href="{{url('/')}}">Home </a></li>
            <li style="display : inline-block"><a href="{{url('/product').'/'.$detailProduct->none_name}}">>> {{$detailProduct->name}}</a></li>
        </ul>
    </div>
    <div class="row w100">
        <div class="col-md-9" style="padding-left : 0">
            <div class="row w100" style="background-color: #155e90;text-align: center">
                <h4 style="color : #edff12"><i class="fas fa-shopping-cart"></i> Giao hàng miễn phí toàn quốc</h4>
            </div>
            <div class="row w100" style="margin-top : 10px;">
                <div class="col-md-4" style="padding-left : 0;padding-right : 0">
                    <div style="overflow : hidden;margin-bottom : 10px;" class="h100 w100">
                        <img class="img-responsive img-thumbnail" src="{{asset('public/img/product').'/'.$detailProduct->img}}">
                    </div>
                </div>
                <div class="col-md-8" style="padding : 0">
                    <div style="background-color: #155e90;padding : 10px">
                        <h3 style="color : #fff;margin : 0">{{$detailProduct->name}}</h3>
                    </div>
                    <div style="background : rgb(244, 244, 244);padding : 10px">
                        <p>Nhà sản xuất: {{$detailProduct->producer}}</p>
                    </div>
                    <div style="background : rgb(244, 244, 244);padding : 10px;margin-top : 5px">
                        <p style="font-size : 30px;font-weight : 700">{{number_format($detailProduct->price)}}</p>
                        <div class="row">
                            <div class="col-md-5" style="padding : 0">
                                <div class="w100 h100" style="display : table;height : 50px">
                                    <span id="btn-plus-qty" class="h100 " style="cursor:pointer;display : table-cell;background : #e4e4e4;width : 20%;text-align:center;vertical-align : middle"><i class="fas fa-plus"></i></span>
                                    <span class="h100" style="display : table-cell;width : 60%"><input id="input-qty" style="border : 0;width : 100%;height : 100%;text-align : center" value="1"/></span>
                                    <span id="btn-minus-qty" class="h100" style="background : #e4e4e4;width : 20%;display : table-cell;text-align:center;cursor:pointer;" ><i class="fas fa-minus"></i></span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="w100 h100 f18 b center pointer main-bg-color w-color" style="height : 50px;" id='btn-addProduct'>
                                    <span style="display : block;padding-top : 14px"><i class="fas fa-cart-plus"></i> Thêm Vào Giỏ Hàng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row w100" style="margin-bottom : 10px;">
                        <div class="col-md-12 w100">
                            <div class="fb-share-button" data-href="{{url('/product').'/'.$detailProduct->none_name}}" data-layout="button_count" style="margin : auto;display : inline-block">
                            </div>
                            <div class="fb-like" data-href="{{url('/product').'/'.$detailProduct->none_name}}"  data-layout="button_count" data-action="like"  data-size="small" data-show-faces="true" style="margin : auto;display : inline-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row w100" style="margin-bottom : 10px;">
                <div class="w100 main-bg-color w-color b f14" style="line-height : 3;">
                    <div class="pointer tab-click activeTab" onclick="clickTab(this,'description')" style="display : inline-block;padding :0 10px">Mô tả</div>
                    <div class="pointer tab-click" onclick="clickTab(this,'comment')" style="display : inline-block;border-right : 1px solid #fff;padding : 0 10px">Nhận xét</div>
                </div>
                <div class="w100 p10" style="min-height : 350px;max-height : 500px;overflow-x : hidden;border : 1px solid #155e90">
                    <div class="tab-contain">
                        <div class="tab-item activeTab" href="description" style="color : #333">
                            {{$detailProduct->description}}
                        </div>
                        <div class="tab-item" href="comment" style="color : #333">
                            <div class="fb-comments" data-href="{{url('/product').'/'.$detailProduct->none_name}}" data-numposts="10" data-width="100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding : 0">
            <div class="row w100">
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
            <div class="row w100" style="margin-top : 20px">
                <div class="col-md-12" style="padding-left : 0">
                    <div class="box-item-product">
                        <div class="box-header">
                            Sản phẩm liên quan
                        </div>
                        <div class="box-content">
                            <ul>
                                @foreach($relatedProduct as $pro)
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
    </div>
    <style>
    .tab-click.activeTab{
        color : #155e90;
        background : #fff;
    }
    </style>
    <script>
        $(document).ready(function(){
            $("#btn-plus-qty").click(function(){
                let qty = Number($("#input-qty").val());
                qty++;
                $("#input-qty").val(qty);
            })
            $("#btn-minus-qty").click(function(){
                let qty = Number($("#input-qty").val());
                if(qty > 1) qty--;                
                $("#input-qty").val(qty);
            })
            $("#btn-addProduct").click(function(){
                let data = @json($detailProduct);
                if($("#input-qty").val() != null  && $("#input-qty").val() != '' && $("#input-qty").val() > 0){
                    data.qty = $("#input-qty").val();
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    method : 'POST',
                    url: url+'addCart',
                    data : data,
                    success : function(kq){
                        toastr.success("Thêm giỏ hàng thành công","Success! ");
                        res = $.parseJSON(kq);
                        $("#information-cart").val(`${res.qty} sản phẩm - ${number_format(res.total)} VND`);        
                    }
                });
            })
        })
    </script>
@endsection