<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if(!empty($detailProduct)){?>        
        <meta property="og:url"           content="<?=url('/product').'/'.@$detailProduct->none_name?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?=@$detailProduct->name?>" />
        <meta property="og:description"   content="<?=@$detailProduct->description?>" />
        <meta property="og:image"         content="<?=asset('public/img/product').'/'.@$detailProduct->img?>" />
    <?php } ?>
    <link href="{{asset('public/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/bootstrap/dist/css/bootstrap-theme.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/plugin/carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/plugin/carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/plugin/confirm/jquery-confirm.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/plugin/toast/toast.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/plugin/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/animate.css')}}" rel="stylesheet">
    <link href="/public/css/chat.css" rel="stylesheet">
    <link href="{{asset('public/css/reset.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/style.css')}}" rel="stylesheet">
    <link rel="icon" href="{{asset('public/icon.ico')}}" type="image/x-icon">
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '178133706178123',
                cookie     : true,
                xfbml      : true,
                version    : 'v3.0'
            });                    
        };
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "{{asset('public/js/fb_sdk.js')}}";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script src="{{asset('public/jquery-3.3.1.min.js')}}"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Sega-Group</title>
</head>
<body >
    <header>
        <div class="row-1">
            <nav class="navbar navbar-default" style="margin-bottom: 0;">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                
                        </button>
                        <a class="navbar-brand" href="{{url('')}}">SEGA </a>
                    </div>
                    <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="{{url('')}}"><i class="fas fa-home"></i> SEGA <?=env('MAIL_USERNAME');?></a></li>
                            <li><a href="#"><i class="fas fa-phone"></i> Hotline: 1900xxxx</a></li>
                            <li><a href="#"><i class="fas fa-envelope"></i> contact@sega.com</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <?php if(!Auth::guard('web')->check()){ ?>
                            <li><a href="{{url('verify')}}">Đăng nhập hoặc đăng ký | </a></li>
                            <li>
                                <a href="javascript:void(0)">
                                    <button class="btn btn-primary" onclick="loginFB()">Login With FB</button>
                                    <!-- <div class="fb-login-button" data-max-rows="1" data-size="small" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div> -->
                                    |
                                </a>                                
                            </li>
                            <?php }else{ ?>
                                <li><a href="{{url('logout')}}">Đăng xuất | </a></li>
                                <li><a href="{{url('profile')}}">@if(!empty(Auth::guard('web')->user()->name)) {{ Auth::guard('web')->user()->name}} @else {{ Auth::guard('web')->user()->email}} @endif | </a></li>
                            <?php } ?>
                            <li><a href="#"> Hỗ trợ khách hàng | </a></li>
                            <li><a href="#" onclick="testNode()">Liên hệ | </a></li>
                            <li><a href="#" onclick="testFB()"><i class="fab fa-facebook-f"></i></a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row-2">
            <div class="row" style="width : 70%;margin : auto;line-height : 4">
                <div class="col-md-4" style="margin-top : 20px">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control"  aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-md-4 center hidden-sm hidden-xs">
                    <div class="img">
                        <a href="#"><img src="{{asset('public/img/white-icon.png')}}" /></a>
                    </div>
                </div>
                <div class="col-md-4 hidden-sm hidden-xs" style="margin-top : 20px">
                    <div class="input-group">
                        <input id="information-cart" style="background : #fff" type="text" class="form-control"  aria-describedby="basic-addon1" value="{{\Cart::getTotalQuantity()}} sản phẩm - {{number_format(\Cart::getTotal())}} VND" disabled>
                        <a href="{{url('cart')}}" class="input-group-addon" id="basic-addon1"><i class="fas fa-shopping-cart"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-3">
            <div class="row">
                <nav class="navbar navbar-default">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>                
                            </button>
                            <a class="hidden-md hidden-lg navbar-brand" href="#">MENU</a>
                        </div>
                        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-2" style="z-index : 100">
                            <ul class="nav navbar-nav">
                                <li><a href="{{url('')}}"><i class="fas fa-home"></i></a></li>
                                @foreach($categoryShare as $cate)
                                    @if($cate->parent == 0)
                                    <li class="list-menu ">
                                        <a href="{{url('category/').'/'.$cate->none_name}}"><i class="fab fa-asymmetrik"></i> {{$cate->name}}</a>
                                        <ul class="list-menu-child">
                                            @foreach($categoryShare as $cateChild)
                                                @if($cateChild->parent == $cate->id)
                                                    <li class="item"><a href="{{url('category/').'/'.$cateChild->none_name}}">{{str_limit($cateChild->name)}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                @endforeach
                                <li class="list-menu">
                                    <a href="{{url('producer')}}"><i class="fab fa-opencart"></i> Hãng sản xuất</a>
                                    <ul class="list-menu-child">
                                        @foreach($producerShare as $producer)
                                            <li class="item"><a href="{{url('producer').'/'.$producer->none_name}}">{{str_limit($producer->name,20)}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{url('')}}"><i class="fas fa-users"></i> Tuyển dụng</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <section class="container" style="margin-top : 10px">
        @yield('content')
    </section>
    <footer></footer>
    <section style="max-height : 400px">
        <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="width: 350px;margin:0px;position: fixed;z-index : 1000;right: 0;padding : 0">
            <div class="col-xs-12 col-md-12" style="padding : 0">
                <div class="panel panel-default ">
                    <div class="panel-heading top-bar">
                        <div class="col-md-8 col-xs-8">
                            <h3 class="panel-title "><span class="glyphicon glyphicon-comment "></span> Chat <span id="chat-status"></span></h3>
                        </div>
                        <div class="col-md-4 col-xs-4" style="text-align: right;">
                            <a href="javascript:void(0)" style="display : inline-block" id="refresh-chat"><span class="glyphicon glyphicon-refresh "></span></a>
                            <a href="javascript:void(0)" style="display : inline-block"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim "></span></a>
                            <a href="javascript:void(0)" style="display : inline-block" id="close-chat"><span class="glyphicon glyphicon-remove icon_close " data-id="chat_window_1"></span></a>
                        </div>
                    </div>
                    <div  class="panel-body" style="padding : 0">
                        <div id="chat_mess" class="msg_container_base"></div>
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here...">
                            <span class="input-group-btn">
                            <button class="btn btn-primary btn-sm" id="btn-chat" style="margin-left : 0;height : 30px">Send</button>
                            </span>
                        </div>    
                    </div>            
                </div>
            </div>
        </div>
    </section>
</body>

<script src="{{asset('public/bootstrap.min.js')}}"></script>
<script src="{{asset('public/plugin/carousel/dist/owl.carousel.min.js')}}"></script>
<script src="{{asset('public/plugin/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('public/plugin/confirm/jquery-confirm.min.js')}}"></script>
<script src="{{asset('public/plugin/toast/toast.min.js')}}"></script>
<script src="{{asset('public/plugin/select2/select2.min.js')}}"></script>
<script src="{{asset('public/plugin/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="https://sega-group.com:3000/socket.io/socket.io.js"></script>
<script>
    const url = "{{url('')}}/ajax/";
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    const ip = "<?php echo $_SERVER["REMOTE_ADDR"]; ?>";
</script>
<script src="{{asset('public/js/script.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
            loop:false,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        })        
        toastr.options = {
            "positionClass": "toast-bottom-right",
        }
        $('[data-toggle="tooltip"]').tooltip();
        $('li.list-menu').mouseenter(function(){
            $(this).addClass('activeList');
        })
        $('li.list-menu').mouseleave(function(){
            $(this).removeClass('activeList');
        })
        $('.list-menu-child .item').mouseenter(function(){
            $(this).css("background","#fff");
            $(this).children("a").css("color","#155e90");
        })
        $('.list-menu-child .item').mouseleave(function(){
            $(this).css("background","#155e90");
            $(this).children("a").css("color","#fff");
        })        
    })
    function loginFB(){
        FB.login(function(response) {
            if (response.status === 'connected') {
                // Logged into your app and Facebook.
            } else {
                // The person is not logged into this app or we are unable to tell. 
            }
        },{scope: 'public_profile,email'});
    }
    function testFB(){
        FB.getLoginStatus(function(response) {
            console.log(response);
        });
    }
</script>
<script src="{{asset('public/js/chat-script.js')}}"></script>

</html>