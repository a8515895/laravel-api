<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;
class Provider extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListProvider(){
        $data = DB::table('provider')
                ->leftJoin("province","provider.province","=","province.provinceid")
                ->leftJoin("district","provider.district","=","district.districtid")
                ->join("admin","provider.create_by","=","admin.id")
                ->select('provider.id','provider.name','provider.phone','provider.email','provider.address','district.name as district','province.name as province','provider.create_at','admin.name as create_by','district.districtid','province.provinceid')
                ->orderBy("provider.create_at","desc")
                ->get();
        return $data;
    }
    public function getDetailProvider(Request $rq){
        $data = DB::table('provider')
                ->leftJoin("province","provider.province","=","province.provinceid")
                ->leftJoin("district","provider.district","=","district.districtid")
                ->where("provider.id",$rq->id)
                ->select('provider.id','provider.name','provider.phone','provider.email','provider.address','district.name as district','province.name as province','provider.create_at','district.districtid','province.provinceid')
                ->orderBy("provider.create_at","desc")
                ->first();
        return json_encode($data);
    }
    public function getProvince(){
        return DB::table('province')->select("provinceid as id","name as text")->get();
    }
    public function getDistrict(Request $rq){
        return DB::table('district')->where("provinceid",$rq->id)->select("districtid as id","name as text")->get();
    }
    public function addProvider(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('provider')->where(["email"=>$data['email']])->first())){
            return array("err"=>"Khách hàng có email này đã tồn tại");
        }
        if(!empty(DB::table('provider')->where(["phone"=>$data['phone']])->first())){
            return array("err"=>"Khách hàng có số điện thoại này đã tồn tại");
        }
        $data=array_merge($data,["create_at"=>strtotime('now')]);
        DB::table('provider')->insert($data);
        return array("err"=>0);
    }
    public function deleteProvider(Request $rq){       
        $data = DB::table('provider')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
    public function updateProvider(Request $rq){
        return $rq;
    }
}
