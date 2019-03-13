<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Library\MyFunction;
use DB;
class Product extends Controller
{
    private $myfunction;
    private $urlHinh="/home/sega-group/domains/laravel.sega-group.com/public_html/public/img/product/";
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListProduct(){
        $data = DB::table('product')
                ->join('category', 'product.id_category', '=', 'category.id')
                // ->join('producer', 'product.id_producer', '=', 'producer.id')
                ->select('product.*','category.name as category')
                ->orderBy('id', 'desc')
                ->get();
        return $data;
    }
    public function addProduct(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('product')->where(["name"=>$data['name']])->first())){
            return array("err"=>"Sản phẩm này đã tồn tại");
        }
        $data=array_merge($data,["none_name"=>$this->myfunction->xoaDau($rq->name)."-".$now,"create_at"=>strtotime('now')]);
        if(!empty($data['img']['value'])){
            Image::make(base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$data['img']['value'])))->resize(220,320)->save($this->urlHinh.$data['none_name'].".png");
            $data['img'] = $data['none_name'].".png";
        }else{
            unset($data['img']);
        }
        $data['id_category'] = $data['category'];
        unset($data['category']);
        unset($data['option']);
        
        DB::table('product')->insert($data);
        return array("err"=>0);
    }
    public function deleteProduct(Request $rq){
        foreach(DB::table('product')->whereIn("id",$rq->all())->get() as $item){
            if($item->img != "empty.png") unlink($this->urlHinh.$item->img);
        }        
        $data = DB::table('product')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
    public function updateProduct(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(count(DB::table('product')->where(["name"=>$data['name']])->get()) > 1){
            return array("err"=>"Sản phẩm này đã tồn tại");
        }
        $data=array_merge($data,["none_name"=>$this->myfunction->xoaDau($rq->name)."-".$now,"update_at"=>$now]);
        if(!empty($data['img']['value'])){
            $img=DB::table('product')->select("img")->where(["name"=>$data['name']])->first()->img;
            unlink($this->urlHinh.$img);
            Image::make(base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$data['img']['value'])))->resize(220,320)->save($this->urlHinh.$data['none_name'].".png");
            unset($data['img']);
            $data['img'] = $data['none_name'].".png";
        }
        unset($data['img']);
        if(isset($data['producer']))unset($data['producer']);
        $data['id_category'] = $data['category'];
        unset($data['category']);
        $data['id_producer'] = $data['producer'];
        unset($data['producer']);
        DB::table('product')->where("id","=",$rq->id)->update($data);
        return array("err"=>0);
    }
}
