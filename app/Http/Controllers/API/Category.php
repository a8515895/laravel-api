<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;
class Category extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListCategory(){
        return DB::table('category')->leftJoin('category AS t1', 'category.parent', '=', 't1.id')->select("category.id","category.name","category.icon","category.parent","t1.name as parent_name")->get();
    }    
    public function addCategory(Request $rq){
        $data = $rq->all();
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('category')->where(["name"=>$data['name']])->first())){
            return array("err"=>"Chủ đề này đã tồn tại");
        }
        $data=array_merge($data,["none_name"=>$this->myfunction->xoaDau($rq->name)."-".strtotime('now'),"create_at"=>strtotime('now')]);
        DB::table('category')->insert($data);
        return array("err"=>0);
    }
    public function deleteCategory(Request $rq){
        $data = DB::table('category')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
    public function updateCategory(Request $rq){
        $data = $rq->all();
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        unset($data['parent_name']);
        if(!empty(DB::table('category')->where(["name"=>$data['name']])->first())){
            return array("err"=>"Chủ đề này đã tồn tại");
        }
        $data=array_merge($data,["none_name"=>$this->myfunction->xoaDau($rq->name)."-".strtotime('now'),"update_at"=>strtotime('now')]);
        DB::table('category')->where(["id"=>$data['id']])->update($data);
        return array("err"=>0);
    }   
    
}
