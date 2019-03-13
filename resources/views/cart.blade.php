@extends('layout.index')
@section('content')
    <div class="row">
        <ul>
            <li style="display : inline-block"><a href="{{url('/')}}">Home </a></li>
            <li style="display : inline-block"><a href="{{url('/cart')}}">>> Giỏ hàng</a></li>
        </ul>
    </div>
    <div class="row w100">
        <div class="col-md-10 pdl0 pdr0">
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
        <div class="col-md-2 pdr0">
            <button class="btn btn-warning btn-block" onclick="removeCart()"><i class="fas fa-trash pointer" ></i> Xóa hết giỏ hàng</button>
            <a href="{{url('cart/payment')}}" class="btn btn-success btn-block mgt10"><i class="fas fa-fast-forward pointer"></i> Thanh toán</a>
        </div>
    </div>
@endsection