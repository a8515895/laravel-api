<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Cart;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Library\MyFunction;
use App\Mail\SegaEmail;
class HomeController extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
        $data['categoryShare']=DB::table("category")->get();
        $data['producerShare']=DB::table("producer")->where("status",1)->get();    
        $data['userShare']=Auth::guard('web')->id();  
        View::share($data);
    }
    public function index(){    
        $category= [];
        $data['category']=DB::table("category")->where("parent","0")->get();
        $data['categoryChild']=DB::table("category")->where("parent","!=","0")->get();
        foreach($data['category'] as $cate){
            $data['product'][$cate->id] = [];
        }
        $products=DB::table("product")->orderBy('create_at','desc')->get();
        foreach($products as $pro){
            $check = false;
            foreach($data['category'] as $cate){    
                if(count($data['product'][$cate->id])<10){            
                    if($pro->id_category == $cate->id){
                        array_push($data['product'][$cate->id],$pro);
                        $check = true;
                        break;
                    }
                }
            }
            if($check == false){
                foreach($data['categoryChild'] as $cate){
                    if(count($data['product'][$cate->parent])<10){            
                        if($pro->id_category == $cate->id){
                            array_push($data['product'][$cate->parent],$pro);
                            break;
                        }
                    }
                }
            }
        }
        return view("home",$data);
    }
    public function sendMail(){
        Mail::to("a8515895@gmail.com")
        ->send(new SegaEmail());
    }
    public function file_not_found(){        
        return view("404");
    }
    public function profile(Request $rq){
        $data['province'] = DB::table('province')->get();
        $data['district']=[];
        if(Auth::guard('web')->check()){
            if(Auth::guard('web')->user()->district || Auth::guard('web')->user()->province) $data['district'] = DB::table('district')->where("provinceid",Auth::guard('web')->user()->province)->get();
        }
        return view('profile',$data);
    }
    public function updateProfile(Request $rq){
        if(!empty($rq->password)){
            if($rq->password == $rq->repassword){
                $data['password']=\Hash::make($rq->password);
            }else{
                echo json_encode(array("err"=>"Password và Re-Password không giống nhau"));
            }
        }
        $user = Auth::guard('web')->user();
        if(!empty($rq->email)){
            $data['email']=$rq->email;
            $user->email=$data['email'];
        }
        if(!empty($rq->name)){
            $data['name']=$rq->name;
            $user->name=$data['name'];
        }
        if(!empty($rq->phone)){
            $data['phone']=$rq->phone;
            $user->phone=$data['phone'];
        }
        if(!empty($rq->address)){
            $data['address']=$rq->address;
            $user->address=$data['address'];
        }
        if(!empty($rq->province)){
            $data['province']=$rq->province;
            $user->province=$data['province'];
        }
        if(!empty($rq->district)){
            $data['district']=$rq->district;
            $user->district=$data['district'];
        }
        $user->save();
        DB::table("customer")->where("id",Auth::guard('web')->user()->id)->update($data);
        echo 0;

    }
    public function changeProvince(Request $rq){
        $district = DB::table("district")->where("provinceid",$rq->id)->get();
        $div="<option value='0'> --- Mời chọn quận ---</option>";
        foreach($district as $dis){
            $div.="<option value='".$dis->districtid."'>".$dis->name."</option>";
        }
        echo $div;
    }
    public function addCart(Request $rq){     
        $qty = 1;
        if(!empty($rq->qty)) $qty = $rq->qty; 
        \Cart::add($rq->id, $rq->name, $rq->price,$qty,array('img'=>$rq->img,'none_name'=>$rq->none_name)); 
        echo json_encode(array("qty"=>\Cart::getTotalQuantity(),"total"=>\Cart::getTotal()));     
    }
    public function updateCart(Request $rq){   
        if(empty($rq->qty)) $rq->qty = 1;    
        \Cart::update($rq->id,array('quantity'=>array(
            'relative' => false,
            'value' => $rq->qty,
        ))); 
        echo json_encode(array("qty"=>\Cart::getTotalQuantity(),"total"=>\Cart::getTotal()));     
    }
    public function removeCart(Request $rq){  
        if(!empty($rq->id)) \Cart::remove($rq->id);   
        else \Cart::clear();     
        return \Cart::getContent();
    }
    public function detailProduct(Request $rq){
        $data = [];
        $data['detailProduct']=DB::table("product")->leftJoin("producer","producer.id","=","product.id_producer")->where(["product.none_name"=>$rq->id])->select("product.id","product.name","product.img","product.price","product.none_name","producer.name as producer","product.description","id_category")->first();
        $data['newProduct']=DB::table("product")->where("none_name","!=",$rq->id)->orderBy('create_at','desc')->limit(5)->get();
        $data['relatedProduct']=DB::table("product")->where([["none_name","!=",$rq->id],["id_category","=",$data['detailProduct']->id_category]])->orderBy('create_at','desc')->limit(5)->get();
        return view('product',$data);
    }
    public function detailPC(Request $rq){
        $data = [];   
        $table=$rq->segment(1);  
        $data['table']=$table;
        $data['namePC'] = $table=="category" ? "Chủ đề" : "Nhà sản xuất"; 
        $order_name= empty($rq->query('order_name')) ? 'name' : $rq->query('order_name');  
        $order_type= empty($rq->query('order_type')) ? 'asc' : $rq->query('order_type');  
        $limit= empty($rq->query('limit')) ? '8' : $rq->query('limit');  
        $data['pc']=DB::table($table)->where([["none_name",$rq->id],["status",1]])->select("name","none_name","id")->first();
        $condtion = $table == 'category' ? ["id_category",$data['pc']->id] : ["id_producer",$data['pc']->id];
        $data['newProduct']=DB::table("product")->where([$condtion])->orderBy('create_at','desc')->limit(5)->get();
        $data['product']=DB::table("product")->where([$condtion])->orderBy($order_name,$order_type)->paginate($limit);
        return view('detailPC',$data);
    }
    public function listPC(Request $rq){
        $data = [];
        $table=$rq->segment(1);
        $data['pc']=DB::table($table)->where(["status"=>1])->select("name","none_name","id")->get();
        $data['newProduct']=DB::table("product")->orderBy('create_at','desc')->limit(5)->get();
        $products=DB::table("product")->orderBy('create_at','desc')->get();
        foreach($data['pc'] as $pro){
            $data['product'][$pro->id] = [];              
            foreach($products as $p){
                if($table == "producer"){
                    if($pro->id == $p->id_producer){
                        if(count($data['product'][$pro->id]) < 10){
                            array_push($data['product'][$pro->id],$p);
                        }else{
                            break;
                        }
                    }
                }else{
                    if($pro->id == $p->id_category){
                        if(count($data['product'][$pro->id]) < 10){
                            array_push($data['product'][$pro->id],$p);
                        }else{
                            break;
                        }
                    }
                }
            }            
        }
        $data['table']=$table;
        $data['namePC'] = $table=="category" ? "Chủ đề" : "Nhà sản xuất";
        return view('listPC',$data);
    }
    public function cart(){
        $data['cart']=\Cart::getContent();
        return view('cart',$data);
    }
    public function payment(){
        if(\Cart::isEmpty()){
            return redirect(url(''));
        }
        $data['cart']=\Cart::getContent();
        $data['province'] = DB::table('province')->get();
        if(Auth::guard('web')->check()){
            if(Auth::guard('web')->user()->district || Auth::guard('web')->user()->province) $data['district'] = DB::table('district')->where("provinceid",Auth::guard('web')->user()->province)->get();
        }
        return view('payment',$data);
    }
    public function paymentSuccess(Request $rq){
        if(empty($rq->name) || empty($rq->address) || empty($rq->phone) || empty($rq->province) || empty($rq->district)){
            echo json_encode(array("err"=>"Bạn chưa nhập đủ thông tin cần thiết"));
            return;
        }
        $time = strtotime('now');
        $type = $rq->type;
        $note = $rq->note;
        $bill_code = rand(1001,9999);
        while(!empty(DB::table("bill")->where("bill_code",$bill_code)->first())){
            $bill_code = rand(1001,9999);
        }
        $data = array(
            "note" => $note,
            "bill_code" => $bill_code,
            "total" => Cart::getTotal(),
            "priority" => 4,
            "address" => $rq->address,
            "customer" => $rq->name,
            "province" => $rq->province,
            "district" => $rq->district,
            "phone" => $rq->phone,
            "payment_type"=> $rq->type,
            "create_at"=>$time,
            "requester"=> empty(Auth::guard('web')->check()) ? 0 : Auth::guard('web')->user()->id,
            "create_by"=>0
        );
        DB::table("bill")->insert($data);
        foreach(Cart::getContent() as $cart){
            $data2 = array(
                "id_bill" => $bill_code,
                "id_product" => $cart->id,
                "qty" => $cart->quantity,
                "price" => $cart->price,
            );
            DB::table("bill_detail")->insert($data2);
        }
        Cart::clear();
        echo 0;
        return ;
    }
}