<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;
use Response;
class Room extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function addMessage(Request $rq){
        $data = [
            "id" => md5(md5($rq->admin_send).md5($rq->admin_receive).md5(time()).md5($rq->message)),
            "admin_send" => $rq->admin_send,
            "admin_receive" => $rq->admin_receive,
            "message" => $rq->message,
            "type" => $rq->type,
            "room" => $rq->room,
            "datecreate" => time(),
        ];
        DB::table("message")->insert($data);
    }
    public function getMessageInRoom(Request $rq){
        $data = DB::select(DB::raw("
        SELECT *
        FROM
            (SELECT message,admin_send as id,admin.avartar,message.type,message.datecreate 
            FROM message 
            JOIN  admin ON admin_send = admin.id
            WHERE room = '".$rq->room."'
            ORDER BY datecreate DESC
            LIMIT ".explode(",",$rq->limit)[1]." OFFSET ".explode(",",$rq->limit)[0].") t1 
        ORDER BY t1.datecreate ASC
        "));
        return $data;
    }
}
