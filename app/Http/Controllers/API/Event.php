<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;
class Event extends Controller
{
    //
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListEvent(Request $rq){
        return DB::table('event')->get();
    }
    public function getDetailEvent(Request $rq){
        $data = DB::table('event')->where("id",$rq->id)->first();
        return json_encode($data);
    }
    public function addEvent(Request $rq){
        $now = strtotime('now');
        $event = array(
            'name' => $rq->name,
            'description' =>  $rq->description,
            'startdate' => $rq->startdate,
            'enddate' => $rq->enddate,
            'create_at' => $now,
            'create_by' => $rq->createBy,
        );
        DB::table('event')->insert($event);
        return array("err"=>0);
    }
    public function updateEvent(Request $rq){
        $data = $rq->all();
        $data['update_at'] = strtotime('now');
        DB::table('event')->where([['id',$rq->id]])->update($data);
        return array("err"=>0);
    }
    public function deleteEvent(Request $rq){
        $data = DB::table('event')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
    public function addRowEvent(){
        
    }
}
