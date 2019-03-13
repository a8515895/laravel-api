<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;
class Producer extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListProducer(){
        $data = DB::table('producer')
                ->get();
        return $data;
    }
    public function addProducer(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('producer')->where(["name"=>$data['name']])->first())){
            return array("err"=>"Nhà sản xuất đã tồn tại");
        }
        $data=array_merge($data,["none_name"=>$this->myfunction->xoaDau($rq->name)."-".$now,"create_at"=>strtotime('now')]);
        DB::table('producer')->insert($data);
        return array("err"=>0);
    }
    public function deleteProducer(Request $rq){       
        $data = DB::table('producer')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
    public function updateProducer(Request $rq){
        return $rq;
    }
}
