<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use DB;
class Report extends Controller
{
    private $_view;
    private $_keyChart = [];
    private $conditionTime;
    public function __construct(){
        
    }
    function db($table,$time,$col = "create_at"){
        $conditionTime = [];
        $from = DateTime::createFromFormat('d/m/Y',explode("_",$time)[0])->setTime(0,0)->getTimestamp();
        $to = DateTime::createFromFormat('d/m/Y',explode("_",$time)[1])->setTime(0,0)->getTimestamp();
        if($from == $to){
            $conditionTime = [["$table.$col",">=",$from]];
        }else{
            $conditionTime = [["$table.$col",">=",$from],["$table.$col","<",$to]];
        }
        return DB::table($table)->where($conditionTime);
    }
    function setView($time){
        $from = DateTime::createFromFormat('d/m/Y',explode("_",$time)[0])->setTime(0,0)->getTimestamp();
        $to = DateTime::createFromFormat('d/m/Y',explode("_",$time)[1])->setTime(0,0)->getTimestamp();
        $lengDate = (($to-$from)/86400)+1;
        if($lengDate==1){
            for($i=0;$i<25;$i++){
                $tmp = $i;
                if(strlen($i)==1) $tmp="0".$i;
                array_push($this->_keyChart,$tmp);
            }
            $this->_view= "H";
        }elseif($lengDate>1 && $lengDate < 30){
            $tmpFrom = $from;
            while($tmpFrom<=$to){
                array_push($this->_keyChart,date("d/m",$tmpFrom));
                $tmpFrom += 86400;
            }
            $this->_view = "d/m";
        }elseif($lengDate < 366){
            $this->_view = "m";
            for($i=1;$i<12;$i++){
                $tmp = $i;
                if(strlen($i)==1) $tmp="0".$i;
                array_push($this->_keyChart,$tmp);
            }
        }
    }
    function get_report_sale(Request $rq){        
        $rq->condition = str_replace(","," AND ",$rq->condition);
        $data['data'] = $this->db("bill",$rq->time,$rq->col)->whereRaw(($rq->condition))->get();
        $this->setView($rq->time);
        foreach($this->_keyChart as $k){
            $data['detail']['bill'][$k]=0;
            $data['detail']['price'][$k]=0;
        }
        foreach($data['data'] as $it){
            $it = (array)$it;
            $data['detail']['bill'][date($this->_view,$it[$rq->col])]++;
            $data['detail']['price'][date($this->_view,$it[$rq->col])]+=$it['total'];
        }
        $data['key'] = $this->_keyChart;
        return $data;
    }
    function setTime($time,$col = "created_at"){
        $from =  date("Y-m-d",DateTime::createFromFormat('d/m/Y', explode("_",$time)[0])->setTime(0,0)->getTimestamp());
        $to = date("Y-m-d",DateTime::createFromFormat('d/m/Y', explode("_",$time)[1])->setTime(0,0)->getTimestamp());
        if($from == $to) $this->conditionTime = "DATE($col) >= '$from'";
        else $this->conditionTime = "DATE($col) >= '$from' AND DATE($col) <= '$to'";
        return array(
            "from" => DateTime::createFromFormat('d/m/Y', explode("_",$time)[0])->setTime(0,0)->getTimestamp(),
            "to" => DateTime::createFromFormat('d/m/Y', explode("_",$time)[1])->setTime(0,0)->getTimestamp()
        );
    }
    public function getDoanhThu(Request $rq){
        $time=$this->setTime($rq->time);
        $bill= DB::table("bill")->select("id","total","payment_at","status")->whereRaw($this->conditionTime)->get();
        $import= DB::table("import")->select("id","total","payment_at","status")->whereRaw($this->conditionTime)->get();
        $first = $time['from'];
        $tmpFirst = $first;
        $last = $time['to'];
        $detail = [];
        if($time['from'] != $time['to']){
            if(($time['to']-$time['from'])/86400 > 31){
                $month = 1;
                while($month<=12){
                    $detail['bill'][$month]=0;
                    $detail['import'][$month]=0;
                    $detail['category'][] = "Tháng ".$month;
                    foreach($bill as $it){
                        if(date("m",$it->payment_at) ==  $month && $it->status == "solved") $detail['bill'][date("m",$it->payment_at)]+=$it->total;
                    }
                    foreach($import as $it){                        
                        if(date("m",$it->payment_at) ==  $month && $it->status == "solved") $detail['import'][date("m",$it->payment_at)]+=$it->total;
                    }
                    $month++;
                }
            }else{
                while($tmpFirst<=$last){
                    $detail['bill'][(int)date("d",$tmpFirst)]=0;
                    $detail['import'][(int)date("d",$tmpFirst)]=0;
                    $detail['category'][] = "Ngày ".date("d/m",$tmpFirst);
                    foreach($bill as $it){
                        if(date("d/m",$tmpFirst) == date("d/m",$it->payment_at)){
                            if($it->status == "solved") $detail['bill'][(int)date("d",$it->payment_at)]+=$it->total;
                        }
                    }
                    foreach($import as $it){
                        if(date("d/m",$tmpFirst) == date("d/m",$it->payment_at)){
                            if($it->status == "solved") $detail['import'][(int)date("d",$it->payment_at)]+=$it->total;
                        } 
                    }
                    $tmpFirst+=86400;
                }
            }

        }else{
            $hour = 0;
            while($hour<=23){
                $detail['bill'][$hour]=0;
                $detail['import'][$hour]=0;
                $detail['category'][] = $hour." giờ";
                foreach($bill as $it){
                    if(date("H",$it->payment_at) ==  $hour && $it->status == "solved")$detail['bill'][date("H",$it->payment_at)]+=$it->total;
                }
                foreach($import as $it){
                    if(date("H",$it->payment_at) ==  $hour && $it->status == "solved")$detail['import'][date("H",$it->payment_at)]+=$it->total; 
                }
                $tmpFirst+=3600;
                $hour++;
            }
        }
        return $detail;
    }
    public function getBill(Request $rq){
        $time=$this->setTime($rq->time);
        $bill= DB::table("bill")->select("bill_code as id","total","payment_at","address","status","phone","customer","requester","create_at")->whereRaw($this->conditionTime)->get();
        $first = $time['from'];
        $tmpFirst = $first;
        $last = $time['to'];
        $detail = [];
        $detail['listBill'] = $bill;
        if($time['from'] != $time['to']){
            if(($time['to']-$time['from'])/86400 > 31){
                $month = 1;
                while($month<=12){
                    $detail['bill'][$month]=0;
                    $detail['category'][] = "Tháng ".$month;
                    foreach($bill as $it){
                        if(date("m",$it->payment_at) ==  $month && $it->status == "solved") $detail['bill'][date("m",$it->payment_at)]+=$it->total;
                    }
                    $month++;
                }
            }else{
                while($tmpFirst<=$last){
                    $detail['bill'][(int)date("d",$tmpFirst)]=0;
                    $detail['category'][] = "Ngày ".date("d/m",$tmpFirst);
                    foreach($bill as $it){
                        if(date("d/m",$it->payment_at) ==  date("d/m",$tmpFirst) && $it->status == "solved") $detail['bill'][(int)date("d",$tmpFirst)]+=$it->total;
                    }
                    $tmpFirst+=86400;
                }
            }
        }else{
            $hour = 0;
            while($hour<=23){
                $detail['bill'][$hour]=0;
                $detail['category'][] = $hour." giờ";
                foreach($bill as $it){
                    if(date("H",$it->payment_at) == $hour && $it->status == "solved")$detail['bill'][date("H",$it->payment_at)]+=$it->total;
                }
                $tmpFirst+=3600;
                $hour++;
            }
        }
        return $detail;
    }
    public function getImport(Request $rq){
        $time=$this->setTime($rq->time);
        $import= DB::table("import")->select("import_code as id","total","payment_at","address","status","phone","provider as customer","id_provider as requester","create_at")->whereRaw($this->conditionTime)->get();
        $first = $time['from'];
        $tmpFirst = $first;
        $last = $time['to'];
        $detail = [];
        $detail['listImport'] = $import;
        if($time['from'] != $time['to']){
            if(($time['to']-$time['from'])/86400 > 31){
                $month = 1;
                while($month<=12){
                    $detail['import'][$month]=0;
                    $detail['category'][] = "Tháng ".$month;
                    foreach($import as $it){
                        if(date("m",$it->payment_at) ==  $month && $it->status == "solved") $detail['import'][date("m",$it->payment_at)]+=$it->total;
                    }
                    $month++;
                }
            }else{
                while($tmpFirst<=$last){
                    $detail['import'][(int)date("d",$tmpFirst)]=0;
                    $detail['category'][] = "Ngày ".date("d/m",$tmpFirst);
                    foreach($import as $it){
                        if(date("d/m",$it->payment_at) ==  date("d/m",$tmpFirst) && $it->status == "solved") $detail['import'][(int)date("d",$tmpFirst)]+=$it->total;
                    }
                    $tmpFirst+=86400;
                }
            }

        }else{
            $hour = 0;
            while($hour<=23){
                $detail['import'][$hour]=0;
                $detail['category'][] = $hour." giờ";
                foreach($import as $it){
                    if(date("H",$it->payment_at) == $hour && $it->status == "solved")$detail['import'][date("H",$it->payment_at)]+=$it->total;
                }
                $tmpFirst+=3600;
                $hour++;
            }
        }
        return $detail;
    }
    public function getProduct(Request $rq){
        $this->setTime($rq->time,"paymented_at");
        $bill = DB::table("product")->select(DB::raw("product.id,product.name,SUM(bill_detail.price) AS total,SUM(bill_detail.qty) AS qty"))->join("bill_detail","bill_detail.id_product","=","product.id")->join("bill","bill_detail.id_bill","=","bill.bill_code")->where("status","solved")->whereRaw($this->conditionTime)->groupBy("product.id","product.name")->orderBy("total","desc")->get();        
        $import = DB::table("product")->select(DB::raw("product.id,product.name,SUM(import_detail.price) AS total,SUM(import_detail.qty) AS qty"))->join("import_detail","import_detail.id_product","=","product.id")->join("import","import_detail.id_import","=","import.import_code")->where("status","solved")->whereRaw($this->conditionTime)->groupBy("product.id","product.name")->orderBy("total","desc")->get();        
        return ["import"=>$import,"bill"=>$bill];
    }
}
