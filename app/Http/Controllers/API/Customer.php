<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;

class Customer extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListCustomer(){
        $data = DB::table('customer')
                ->leftJoin("province","customer.province","=","province.provinceid")
                ->leftJoin("district","customer.district","=","district.districtid")
                ->join("admin","customer.create_by","=","admin.id")
                ->select('customer.id','customer.name','customer.phone','customer.email','customer.address','district.name as district','province.name as province','customer.create_at','admin.name as create_by','district.districtid','province.provinceid')
                ->orderBy("customer.create_at","desc")
                ->get();
        return $data;
    }
    public function getDetailCustomer(Request $rq){
        $data = DB::table('customer')
                ->leftJoin("province","customer.province","=","province.provinceid")
                ->leftJoin("district","customer.district","=","district.districtid")
                ->where("customer.id",$rq->id)
                ->select('customer.id','customer.name','customer.phone','customer.email','customer.address','district.name as district','province.name as province','customer.create_at','district.districtid','province.provinceid')
                ->orderBy("customer.create_at","desc")
                ->first();
        return json_encode($data);
    }
    public function getProvince(){
        return DB::table('province')->select("provinceid as id","name as text")->get();
    }
    public function getDistrict(Request $rq){
        return DB::table('district')->where("provinceid",$rq->id)->select("districtid as id","name as text")->get();
    }
    public function addCustomer(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('customer')->where(["email"=>$data['email']])->first())){
            return array("err"=>"Khách hàng có email này đã tồn tại");
        }
        if(!empty(DB::table('customer')->where(["phone"=>$data['phone']])->first())){
            return array("err"=>"Khách hàng có số điện thoại này đã tồn tại");
        }
        $data=array_merge($data,["create_at"=>strtotime('now')]);
        DB::table('customer')->insert($data);
        return array("err"=>0);
    }
    public function deleteCustomer(Request $rq){       
        $data = DB::table('customer')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
    public function updateCustomer(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('customer')->where([["email","=",$data['email']],["id","!=",$rq->id]])->first())){
            return array("err"=>"Khách hàng có email này đã tồn tại");
        }
        if(!empty(DB::table('customer')->where([["phone","=",$data['phone']],["id","!=",$rq->id]])->first())){
            return array("err"=>"Khách hàng có số điện thoại này đã tồn tại");
        }
        $data=array_merge($data,["update_at"=>strtotime('now')]);
        DB::table('customer')->where('id', $rq->id)->update($data);
        return array("err"=>0);
    }
}
