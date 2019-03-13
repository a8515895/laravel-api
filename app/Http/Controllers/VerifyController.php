<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Hash;
use DB;
use App\Library\MyFunction;
class VerifyController extends Controller
{
    private $myfunction;
    public function __construct(){

        $this->myfunction = new MyFunction;
        $data['categoryShare']=DB::table("category")->get();
        $data['producerShare']=DB::table("producer")->where("status",1)->get();    
        $data['cartShare']['totalQTY']=\Cart::getTotalQuantity();   
        $data['cartShare']['total']=\Cart::getTotal();     
        View::share($data);
    }
    public function index(){
        $data = [];        
        return view("verify",$data);
    }
    public function login(Request $rq){
        $credentials = $rq->only('email','password');
        if (Auth::guard('web')->attempt($credentials)) {
            return 0;
        }
        return json_encode(["err"=>"Đăng nhập thất bại"]);
    }
    public function logout(Request $rq){
        Auth::logout();
        return redirect()->back();
    }
    public function register(Request $rq){
        if(empty($rq->email) || empty($rq->password) || empty($rq->repassword)){
            echo json_encode(array("err"=>"Bạn không nhập đầy dủ thông tin"));
            return;
        }
        if($rq->password != $rq->repassword){
            echo json_encode(array("err"=>"Nhập lại password không khớp"));
            return;
        }
        if(!empty(DB::table("customer")->where("email",$rq->email)->first())){
            echo json_encode(array("err"=>"Email đã tồn tại"));
            return;
        }
        DB::table("customer")->insert(["email"=>$rq->email,"password"=>Hash::make($rq->password)]);
        echo 0;
        return;
    }
}
