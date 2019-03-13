<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;
class Dashboard extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function setTime($date){
        $from_date = explode("_",$date)[0];
        $to_date = explode("_",$date)[1];
    }
    public function detail(){
        $detail=[];
        $product = DB::table("product")->get();
        foreach($product as $pro){
            $detail['product'][$pro->name]=0;
        }
        $data=DB::table("bill_detail")->get();
        foreach($data as $it){
            foreach($product as $pro){
                if($it->id_product == $pro->id)
                $detail['product'][$pro->id]+=$it->qty;
            }
        }
        $detail['total_bill']=DB::table("bill")->select(DB::raw("SUM(total) as total"))->first()->total;
        return $detail;
    }
    public function getDoanhThuMonth(){
        $bill= DB::table("bill")->select("id","total","payment_at","status")->where("payment_at",">=",strtotime("midnight first day of this month"))->get();
        $import= DB::table("import")->select("id","total","payment_at","status")->where("payment_at",">=",strtotime("midnight first day of this month"))->get();
        $first = strtotime("midnight first day of this month");
        $tmpFirst = $first;
        $last = strtotime("midnight last day of this month");
        $detail = [];
        while($tmpFirst<=$last){
            $detail['bill'][(int)date("d",$tmpFirst)]=0;
            $detail['import'][(int)date("d",$tmpFirst)]=0;
            foreach($bill as $it){
                if(date("d",$tmpFirst) == date("d",$it->payment_at) && $it->status == "solved"){
                    $detail['bill'][(int)date("d",$tmpFirst)]+=$it->total;
                } 
            }
            foreach($import as $it){
                if(date("d",$tmpFirst) == date("d",$it->payment_at)  && $it->status == "solved"){
                    $detail['import'][(int)date("d",$tmpFirst)]+=$it->total;
                } 
            }
            $tmpFirst+=86400;
        }
        return $detail;
    }
    public function getDoanhThuToday(){
        $detail = [];
        $bill= DB::table("bill")->select("id","total","payment_at","status")->where("payment_at",">=",strtotime("today"))->get();
        $import_today = DB::table("import")->select(DB::raw("SUM(total) as num"))->where("payment_at",">=",strtotime("today"))->first()->num;
        $detail['import_today']= empty($import_today) ? 0 : $import_today;
        $detail['doanhthu_today']= DB::select("SELECT doanhthu_today() as num")[0]->num;
        $detail['doanhthu_month']= DB::select("SELECT doanhthu_month() as num")[0]->num;
        $import= DB::table("import")->select("id","total","payment_at","status")->where([["payment_at",">=",strtotime("today")]])->get();
        $totalBill= DB::table("import")->select(DB::raw("SUM(total) as total"))->where([["payment_at",">=",strtotime("today")],["status","solved"]])->first();
        $first = strtotime("today");
        $tmpFirst = $first;
        $last = strtotime("tomorrow");
        $detail['numBill'] = count($bill);
        $detail['totalBill']['present'] = empty($totalBillToday->num) ? 0 : $totalBillToday->num;
        $detail['numImport'] = count($import);
        while($tmpFirst<$last){
            $detail['bill'][(int)date("H",$tmpFirst)]=0;
            $detail['import'][(int)date("H",$tmpFirst)]=0;
            foreach($bill as $it){
                if(date("H",$tmpFirst) == date("H",$it->payment_at)  && $it->status == "solved"){
                    $detail['bill'][(int)date("H",$tmpFirst)]+=$it->total;
                } 
            }
            foreach($import as $it){
                if(date("H",$tmpFirst) == date("H",$it->payment_at)  && $it->status == "solved"){
                    $detail['import'][(int)date("H",$tmpFirst)]+=$it->total;
                } 
            }
            $tmpFirst+=3600;
        }
        return $detail;
    }

    public function getTop10Product(){
        $top = DB::table("bill_detail")
                ->join("product","product.id","=","bill_detail.id_product")
                ->select(DB::raw("product.name,SUM(qty) as num"))
                ->limit(10)
                ->groupBy('bill_detail.id_product','product.name')
                ->orderBy('num', 'desc')
                ->get();
        return $top;
    }
}
