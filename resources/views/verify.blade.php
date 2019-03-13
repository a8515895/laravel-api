@extends('layout.index')
@section('content')
    <div class="row">
        <ul>
            <li style="display : inline-block"><a href="{{url('/')}}">Home </a></li>
            <li style="display : inline-block"><a href="{{url('/Verify')}}">>> Verify</a></li>
        </ul>
    </div>
    <div class="row w100 mgt10 ">
        <div class="col-md-6 pdl0">
            <div class="panel panel-primary">
                <div class="panel-heading">Đăng Nhập</div>
                <div class="panel-body">
                    <form id="form1" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button id="submitForm1" class="btn btn-primary" type="button" onclick="clickForm('form1','{{url('ajax/login')}}',{title : 'Error !',url : '{{url('')}}'})"> Đăng nhập </button>
                                </div>
                                <div class="col-md-6">
                                    <div class="fb-login-button pull-right" data-max-rows="1" data-size="medium" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 pdr0">
            <div class="panel panel-success">
                <div class="panel-heading">Đăng Ký</div>
                <div class="panel-body">
                    <form id="form2" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" placeholder="Email">
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
                                    <button id="submitForm2" class="btn btn-success pull-right" type="button" onclick="clickForm('form2','{{url('ajax/register')}}',{title : 'Error !',url : '{{url('verify')}}'})"> Đăng ký </button>
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