@extends('layout.index')
@section('content')
    <div class="row">
        <ul>
            <li style="display : inline-block"><a href="{{url('/')}}">Home</a></li>
            <li style="display : inline-block"><a href="{{url('/profile')}}">>> Profile</a></li>
        </ul>
    </div>
    <div class="row w100 mgt10 ">
        <div class="col-md-6 pdl0">
            <div class="panel panel-primary">
                <div class="panel-heading">Thông tin đăng nhập</div>
                <div class="panel-body">
                    <form id="form" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" value="{{Auth::guard('web')->user()->email}}" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nhập lại password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="repassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 ">
                                    <button id="submitForm1" class="btn btn-primary pull-right" type="button" onclick="clickForm('form','{{url('ajax/updateProfile')}}',{title : 'Error !',url : '{{url('profile')}}'})"> Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
        <div class="col-md-6 pdr0">
            <div class="panel panel-success">
                <div class="panel-heading">Thông tin tài khoản</div>
                <div class="panel-body">
                    <form id="form2" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-4 control-label" >Họ và tên*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="Họ và tên" value="{{Auth::guard('web')->user()->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" >Số điện thoại*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" value="{{Auth::guard('web')->user()->phone}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" >Địa chỉ*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="{{Auth::guard('web')->user()->address}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" >Tỉnh/Thành Phố*</label>
                            <div class="col-sm-8">
                                <select id="select-province" class="form-control" name="province">
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
                        <div class="form-group">
                            <label class="col-sm-4 control-label" >Quận/Huyện*</label>
                            <div class="col-sm-8">
                                <select id="select-district2" class="form-control" name="district">
                                    <option value="0"> --- Mời chọn quận ---</option>
                                    @if(!empty($district))
                                        @foreach($district as $tp)
                                            @if($tp->districtid == Auth::guard('web')->user()->district)
                                                <option value="{{$tp->districtid}}" selected>{{$tp->name}}</option>
                                            @else
                                                <option value="{{$tp->districtid}}" >{{$tp->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 ">
                                    <button id="submitForm2" class="btn btn-success pull-right" type="button" onclick="clickForm('form2','{{url('ajax/updateProfile')}}',{title : 'Error !',url : '{{url('profile')}}'})"> Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#select-province,#select-district").select2({
                width : "100%"
            })
            $("#select-province").change(function(){
                let val = $(this).val();
                $.get("{{url('ajax/changeProvince')}}",{id : val},function(kq){ $("#select-district").html(kq)});
            })
            $("#form1").on("keyup",function(e){
                if(e.keyCode==13){
                    $("#submitForm1").click();
                }
            })
            $("#form2").on("keyup",function(e){
                if(e.keyCode==13){
                    $("#submitForm2").click();
                }
            })
        })
    </script>
@endsection