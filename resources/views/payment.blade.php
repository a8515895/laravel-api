@extends('layout.index')
@section('content')
    <div class="row">
        <ul>
            <li style="display : inline-block"><a href="{{url('/')}}">Home </a></li>
            <li style="display : inline-block"><a href="{{url('/cart')}}">>> Giỏ hàng</a></li>
            <li style="display : inline-block"><a href="{{url('/cart/paymnet')}}">>> Thanh toán</a></li>
        </ul>
    </div>
    <div class="row mgt10">
        <div class="col-md-12 main-bg-color lh3 w-color">
            Thanh toán nhanh
        </div>
    </div>
    <div class="row mgt10">
        <div class="col-md-4 pdl0 pdr0">
            <div class="row">
                <div class="col-md-12 pdl0 pdr0">
                    <div class="lh3 main-bg-color w-color pdl10" style="">Chọn thông tin thanh toán</div>
                    <?php if(Auth::guard('web')->check()){ ?>
                        <div class="lh3 pdl10" style="background : #f4f4f4;"><label style="color : #333" class="tab-click " onclick="clickTab(this,'input')"><input type="radio" name="info" value="other" /> Thông tin nhập</label></div>
                        <div class="lh3 pdl10" style="background : #f4f4f4;"><label style="color : #333" class="tab-click activeTab" onclick="clickTab(this,'login')"><input type="radio" name="info" value="register" checked/> Thông tin đăng ký</label></div>
                    <?php }else{ ?>
                        <div class="lh3 pdl10" style="background : #f4f4f4;"><label style="color : #333" class="tab-click activeTab" onclick="clickTab(this,'input')"><input type="radio" name="info" value="other" checked/> Thông tin nhập</label></div>
                        <div class="lh3 pdl10" style="background : #f4f4f4;"><label style="color : #333" class="tab-click" onclick="clickTab(this,'login')"><input type="radio" name="info" value="register" /> Thông tin đăng ký</label></div>
                    <?php } ?>
                </div>
            </div>
            <div class="row mgt10">
                <div class="col-md-12 pdl0 pdr0" style="background : #f4f4f4">
                    <div class="lh3 main-bg-color w-color pdl10" style="">Thông tin thanh toán</div>
                    <div class="tab-contain">
                        <?php if(Auth::guard('web')->check()){ $activeInput = ""; $activeLogin = "activeTab";}else{ $activeInput = "activeTab"; $activeLogin = "";} ?>
                        <div class="tab-item {{$activeInput}}" href="input" style="color : #333">
                            <form id="form" class="form-horizontal" style="margin : 0">
                                {{ csrf_field() }}
                                <div class="form-group mgt10 mgr0 mgl0">
                                    <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Họ và tên*</label>
                                    <div class="col-sm-8 pdr0">
                                        <input type="text" class="form-control" name="name" placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="form-group mgt10 mgr0 mgl0">
                                    <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Email</label>
                                    <div class="col-sm-8 pdr0">
                                        <input type="text" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group mgt10 mgr0 mgl0">
                                    <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Số điện thoại*</label>
                                    <div class="col-sm-8 pdr0">
                                        <input type="text" class="form-control" name="phone" placeholder="Số điện thoại">
                                    </div>
                                </div>
                                <div class="form-group mgt10 mgr0 mgl0">
                                    <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Địa chỉ*</label>
                                    <div class="col-sm-8 pdr0">
                                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ">
                                    </div>
                                </div>
                                <div class="form-group mgt10 mgr0 mgl0">
                                    <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Tỉnh/Thành Phố*</label>
                                    <div class="col-sm-8 pdr0">
                                        <select id="select-province" class="form-control" name="province">
                                            <option value="0"> --- Mời chọn tỉnh ---</option>
                                            @foreach($province as $tp)
                                                <option value="{{$tp->provinceid}}">{{$tp->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mgt10 mgr0 mgl0">
                                    <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Quận/Huyện*</label>
                                    <div class="col-sm-8 pdr0">
                                        <select id="select-district" class="form-control" name="district">
                                            <option value="0"> --- Mời chọn quận ---</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-item {{$activeLogin}}" href="login" style="color : #333">
                            <?php if(Auth::guard('web')->check()){ ?>
                                <form id="form-have-login" class="form-horizontal" style="margin : 0">
                                    {{ csrf_field() }}
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Họ và tên*</label>
                                        <div class="col-sm-8 pdr0">
                                            <input type="text" class="form-control" name="name" placeholder="Họ và tên" value="{{Auth::guard('web')->user()->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Email</label>
                                        <div class="col-sm-8 pdr0">
                                            <input type="text" class="form-control" name="email" placeholder="Email" value="{{Auth::guard('web')->user()->email}}">
                                        </div>
                                    </div>
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Số điện thoại*</label>
                                        <div class="col-sm-8 pdr0">
                                            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" value="{{Auth::guard('web')->user()->phone}}">
                                        </div>
                                    </div>
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px" >Địa chỉ*</label>
                                        <div class="col-sm-8 pdr0">
                                            <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{Auth::guard('web')->user()->address}}">
                                        </div>
                                    </div>
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Tỉnh/Thành Phố*</label>
                                        <div class="col-sm-8 pdr0">
                                            <select id="select-province2" class="form-control" name="province">
                                                <option value="0"> --- Mời chọn tỉnh ---</option>
                                                @foreach($province as $tp)
                                                    @if($tp->provinceid == Auth::guard('web')->user()->province)
                                                        <option value="{{$tp->provinceid}}" selected>{{$tp->name}}</option>
                                                    @else
                                                        <option value="{{$tp->provinceid}}" >{{$tp->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Quận/Huyện*</label>
                                        <div class="col-sm-8 pdr0">
                                            <select id="select-district2" class="form-control" name="district">
                                                <option value="0"> --- Mời chọn quận ---</option>
                                                @foreach(@$district as $dis)
                                                    @if($dis->districtid == Auth::guard('web')->user()->district)
                                                        <option value="{{$dis->provinceid}}" selected>{{$dis->name}}</option>
                                                    @else
                                                        <option value="{{$dis->provinceid}}">{{$dis->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            <?php }else{ ?>
                                <form id="form_login" class="form-horizontal" style="margin : 0" method="POST">
                                    {{ csrf_field() }}    
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Email*</label>
                                        <div class="col-sm-8 pdr0">
                                            <input type="email" class="form-control" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px">Mật khẩu*</label>
                                        <div class="col-sm-8 pdr0">
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                    <div class="form-group mgt10 mgr0 mgl0">
                                        <label class="col-sm-4 control-label pdr0" style="font-size : 11px"></label>
                                        <div class="col-sm-8 pdr0" style="text-align : right">
                                            <a href="{{url('verify')}}" class="btn btn-link">Tạo tài khoản</a>
                                            <button type="button" class="btn btn-primary" onclick="clickForm('form_login','{{url('ajax/login')}}',{url : '{{url('cart/payment')}}'})">Đăng nhập</button>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 pdr0">
            <div class="row">
                <div class="col-md-12 pdr0">
                    <div class="pdr0 lh3 main-bg-color w-color pdl10">Phương thức thanh toán</div>
                    <div class="lh3 pdl10" style="background : #f4f4f4;"><label><input type="radio" name="payment" value="home" checked/> Thu tiền khi giao hàng</label></div>
                    <div class="lh3 pdl10" style="background : #f4f4f4;"><label><input type="radio" name="payment" value="bank" /> Chuyển khoản ngân hàng</label></div>
                </div>
            </div>
            <div class="row mgt10">
                <div class="col-md-12 pdr0">
                    <div class="pdr0 lh3 main-bg-color w-color pdl10">Giỏ hàng</div>
                    <div style="background : #f4f4f4;padding : 5px">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr class="main-bg-color w-color">
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $product)
                                    <tr>
                                        <td>
                                            <div style="height : 100px;overflow : hidden">
                                                <a href="{{url('product').'/'.$product->attributes->none_name}}">
                                                    <img style="height : 100px;" class="img-reponsive img-tdumbnail" src="{{asset('public/img/product').'/'.$product->attributes->img}}" alt="{{$product->name}}" height="50%"/>
                                                </a>
                                            </div>
                                        </td>
                                        <td><a href="{{url('product').'/'.$product->attributes->none_name}}">{{$product->name}}</a></td>
                                        <td>
                                            <input type="text" style="width : 50px;margin : auto;text-align : right;display : inline-block" class="form-control" value="{{$product->quantity}}" onkeydown="checkNumber(event)" onkeyup="updateProduct(event,{{$product->id}})"/>
                                            <button style="display : inline-block" onclick="removeCart({{$product->id}})" class="btn btn-danger"><i class="fas fa-trash pointer"></i></button>
                                        </td>
                                        <td>{{number_format($product->price)}} VND</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="main-bg-color w-color">
                                    <td colspan="2">Tổng cộng</td>
                                    <td>{{\Cart::getTotalQuantity()}}</td>
                                    <td>{{number_format(\Cart::getTotal())}} VND</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mgt10">
                <div class="col-md-12 pdr0">
                    <div class="pdr0 lh3 main-bg-color w-color pdl10">Thêm ghi chú hóa đơn</div>
                    <div style="background : #f4f4f4;padding : 5px">
                        <textarea id="note" class="w100" style="height : 100px"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mgt10">
                <div class="col-md-12 pdr0">
                    <a href="{{url('')}}" class="btn btn-info">Tiếp tục mua sắm</a>
                    <a id="payment_success" href="javascript:void(0)" class="btn btn-success pull-right" >Hoàn tất hóa đơn</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var radio =  $("input[name='payment']").val();
            var radio2 =  $("input[name='info']").val();
            $("#payment_success").on("click",function(){          
                if(radio2 == 'other'){
                    var form = $('form#form');
                }else{
                    var form = $('form#form_login');
                }
                var formData = new FormData(form[0]);
                let note = $("#note").val();
                formData.append("type",radio);
                formData.append("note",note);
                $.ajax({
                    method : 'post',
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    url : url+'payment_success',
                    data: formData,
                    contentType: false, 
                    processData: false,
                    success : function(kq){
                        if(kq == 0){
                            window.location.href = window.location;
                        }else{
                            let res = $.parseJSON(kq);
                            toastr.error(res.err,"Error! ");
                            return;
                        }
                    }
                })
            })
            $("input[name='payment']").on("click",function(){
                radio = $(this).val();
            })
            $("input[name='info']").on("click",function(){
                radio2 = $(this).val();
            })
            $("#select-province,#select-district,#select-province2,#select-district2").select2({
                width : "100%"
            })
            $("#select-province").change(function(){
                let val = $(this).val();
                $.get("{{url('ajax/changeProvince')}}",{id : val},function(kq){ $("#select-district").html(kq)});
            })
            $("#select-province2").change(function(){
                let val = $(this).val();
                $.get("{{url('ajax/changeProvince')}}",{id : val},function(kq){ $("#select-district2").html(kq)});
            })
        })
    </script>
@endsection