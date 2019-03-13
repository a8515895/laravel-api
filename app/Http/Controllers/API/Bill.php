<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;

class Bill extends Controller
{
    //
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListBill(Request $rq){
        return DB::table('bill')->where([['status','new']])->select('id','bill_code','total','status','create_at')->get();
    }
    public function getListAllBill(){
        return DB::table('bill')
                ->leftJoin('admin', 'admin.id', '=', 'assign')
                ->leftJoin('province', 'provinceid', '=', 'bill.province')
                ->leftJoin('district', 'districtid', '=', 'bill.district')
                ->whereNull('table')
                ->select('bill.id','bill_code','bill.status','total','admin.name as assign','bill.customer',DB::raw("CONCAT(bill.address,' ',district.name,' ',province.name) as address"),"bill.phone","bill.payment","bill.payment_type","bill.create_at")
                ->orderBy('create_at', 'desc')
                ->get();
    }
    public function getListBillDetail(Request $rq){
        return DB::table('bill_detail')->leftJoin('product', 'product.id', '=', 'id_product')->where([['id_bill',$rq->id]])->select('id_bill as id','product.img','product.name','bill_detail.price','qty')->get();
    }
    public function addBill(Request $rq){
        $now = strtotime('now');
        $bill_code = rand(1001,99999);
        while(!empty(DB::table("bill")->where("bill_code",$bill_code)->first())){
            $bill_code = rand(1001,99999);
        }
        $bill = array(
            'status' => 'new',
            "bill_code" => $bill_code,
            'total' =>  $rq->total,
            'assign' => $rq->createBy,
            "address" => $rq->address,
            "phone" => $rq->phone,
            'customer' => $rq->name,
            'requester' => $rq->id,
            'province' => $rq->province,
            'district' => $rq->district,
            'priority'=> $rq->priority,
            'create_at' => $now,
            'create_by' => $rq->createBy,
        );
        DB::table('bill')->insert($bill);
        $detailBill=[];
        foreach($rq->detail as $detail){
            unset($detail['img']);
            unset($detail['name']);
            $detail['id_bill'] = $bill_code;
            $detail['id_product'] = $detail['id'];
            unset($detail['id']);
            array_push($detailBill,$detail);
        }
        DB::table('bill_detail')->insert($detailBill);
        return array("err"=>0);
    }
    public function updateBill(Request $rq){
        $data = $rq->all();
        if($rq->payment == 1) {
            $data['payment_at'] = strtotime('now');
            $data['paymented_at'] = date("Y-m-d H:i:s",strtotime('now'));
        }
        $data['update_at'] = strtotime('now');
        $data['status'] = 'solved';
        return DB::table('bill')->where([['id',$rq->id]])->update($data);
    }
    public function deleteBill(Request $rq){
        $data = DB::table('bill')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
}
