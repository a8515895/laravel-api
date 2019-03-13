<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;

class Import extends Controller
{
    //
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListImport(Request $rq){
        return DB::table('import')->where([['status','new']])->select('id','import_code','total','status')->get();
    }
    public function getListAllImport(){
        return DB::table('import')
                ->leftJoin('admin', 'admin.id', '=', 'assign')
                ->select('import.id','import_code','import.status','total','admin.name as assign',"address","import.phone","import.payment","import.payment_type","import.create_at")
                ->orderBy('create_at', 'desc')
                ->get();
    }
    public function getListImportDetail(Request $rq){
        return DB::table('import_detail')->leftJoin('product', 'product.id', '=', 'id_product')->where([['id_import',$rq->id]])->select('id_import as id','product.img','product.name','import_detail.price','qty')->get();
    }
    public function addImport(Request $rq){
        $now = strtotime('now');
        $import_code = rand(1001,99999);
        while(!empty(DB::table("import")->where("import_code",$import_code)->first())){
            $import_code = rand(1001,99999);
        }
        $import = array(
            'status' => 'solved',
            "import_code" => $import_code,
            'total' =>  $rq->total,
            'type' =>  $rq->type,
            'address' =>  $rq->address,
            'id_provider' =>  $rq->requester,
            'assign' => $rq->createBy,
            "phone" => $rq->phone,
            'provider' => $rq->name,
            'create_at' => $now,
            'payment_at' => $now,
            'paymented_at' => date("Y-m-d H:i:s",$now),
            'create_by' => $rq->createBy,
        );
        DB::table('import')->insert($import);
        $detailImport=[];
        foreach($rq->detail as $detail){
            unset($detail['img']);
            unset($detail['name']);
            $detail['id_import'] = $import_code;
            $detail['id_product'] = $detail['id'];
            unset($detail['id']);
            array_push($detailImport,$detail);
        }
        DB::table('import_detail')->insert($detailImport);
        return array("err"=>0);
    }
    public function updateImport(Request $rq){
        $data = $rq->all();
        if($rq->payment == 1) $data['payment_at'] = strtotime('now');
        $data['update_at'] = strtotime('now');
        $data['status'] = 'solved';
        return DB::table('import')->where([['id',$rq->id]])->update($data);
    }
    public function deleteImport(Request $rq){
        $data = DB::table('import')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
}
