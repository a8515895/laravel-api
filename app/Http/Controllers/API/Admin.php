<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\MyFunction;
use DB;
use Response;
use Hash;
class Admin extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function getListAdmin(Request $rq){
        $data = DB::table('admin')
                ->leftJoin("province","admin.province","=","province.provinceid")
                ->leftJoin("district","admin.district","=","district.districtid")
                ->join("admin AS t1","admin.create_by","=","t1.id")
                ->select('admin.id','admin.avartar','admin.name','admin.phone','admin.email','admin.address','district.name as district','province.name as province','admin.create_at','t1.name as create_by','district.districtid','province.provinceid',"admin.is_login")
                ->orderBy("admin.create_at","desc")
                ->where("admin.id","!=",0);
        if(!empty($rq->condition)){
            $data->where(explode(" ",$rq->condition)[0],explode(" ",$rq->condition)[1],explode(" ",$rq->condition)[2]);
        }
        $data=$data->get();
        return $data;
    }
    public function getListAdminCloneMessage(Request $rq){
        $data = DB::table('admin_message_clone')
                ->join("admin as t1","admin_message_clone.admin_receive","=","t1.id")
                ->join("admin as t2","admin_message_clone.admin_send","=","t2.id")
                ->selectRaw("admin_message_clone.last_message,admin_message_clone.room, t1.id as admin_receive_id, t1.name as admin_receive_name, t1.avartar as admin_receive_avartar, t2.id as admin_send_id, t2.name as admin_send_name, t2.avartar as admin_send_avartar,t1.is_login as admin_receive_is_login,t2.is_login as admin_send_is_login,seen")
                ->orderBy("admin_message_clone.created_at","desc")
                ->whereRaw("FIND_IN_SET('".$rq->id."',admin_view) AND (admin_message_clone.admin_receive = ".$rq->id." OR admin_message_clone.admin_send = ".$rq->id.")");
        if(!empty($rq->condition)){
            $data->where(explode(" ",$rq->condition)[0],explode(" ",$rq->condition)[1],explode(" ",$rq->condition)[2]);
        }
        $data=$data->get();
        return $data;
    }
    public function addAdminCloneMessage(Request $rq){
        $check = DB::table('admin_message_clone')
                ->where([["admin_message_clone.room","=",$rq->room]])
                ->first();
        $data = array(
            "room"          => $rq->room,
            "type_message"  => $rq->type,
            "last_message"  => $rq->last_message,
            "admin_send"    => $rq->admin_send,
            "admin_receive" => $rq->admin_receive,
            "admin_view"=>str_replace("_",",",$rq->room),
            "datecreate"    => time(),
        );
        $table =  DB::table('admin_message_clone');
        if(!empty($check)){
            $table->where([["admin_message_clone.room","=",$rq->room]])->update($data);
        }else{
            $table->insert($data);
        }
        return ;
    }
    public function deleteAdminCloneMessage(Request $rq){
        $timeSQL = date("Y-m-d H:i:s",time());
        
    }
    public function getDetailAdmin(Request $rq){
        $data = DB::table('admin')
                ->leftJoin("province","admin.province","=","province.provinceid")
                ->leftJoin("district","admin.district","=","district.districtid")
                ->where("admin.id",$rq->id)
                ->select('admin.id','admin.name','admin.phone','admin.email','admin.address','district.name as district','province.name as province','admin.create_at','district.districtid','province.provinceid')
                ->orderBy("admin.create_at","desc")
                ->first();
        return \Response::json($data);
    }
    public function getPrivilege(Request $rq){
        $data = DB::table('admin')
                ->where("admin.id",$rq->id)
                ->select('admin.id','privilege')
                ->first();
        $privilege = empty($data) ? [] : json_decode($data->privilege,true);
        return \Response::json($privilege);
    }
    public function getProvince(){
        return DB::table('province')->select("provinceid as id","name as text")->get();
    }
    public function getDistrict(Request $rq){
        return DB::table('district')->where("provinceid",$rq->id)->select("districtid as id","name as text")->get();
    }
    public function addAdmin(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('admin')->where(["email"=>$data['email']])->first())){
            return array("err"=>"Email này đã tồn tại");
        }
        if(!empty($data['phone'])){
            if(!empty(DB::table('admin')->where(["phone"=>$data['phone']])->first())){
                return array("err"=>"Số điện thoại này đã tồn tại");
            }
        }
        if(!empty($data['username'])){
            if(!empty(DB::table('admin')->where(["username"=>$data['username']])->first())){
                return array("err"=>"Tên đăng nhập này đã tồn tại");
            }
        }
        if(!empty($data['password'])){
            if(strlen($data['password'])<6){
                return array("err"=>"Mật khẩu ít nhất 6 ký tự");
            }
            $data['password'] = Hash::make($data['password']);
        }
        $data=array_merge($data,["create_at"=>strtotime('now')]);
        DB::table('admin')->insert($data);
        return array("err"=>0);
    }
    public function registerAdmin(Request $rq){
        $data = $rq->all();
        $now = strtotime('now');
        $data['name'] = mb_convert_case($data['name'], MB_CASE_TITLE, "UTF-8");
        if(!empty(DB::table('admin')->where(["email"=>$data['email']])->first())){
            return array("err"=>"Email này đã tồn tại");
        }
        if(!empty($data['phone'])){
            if(!empty(DB::table('admin')->where(["phone"=>$data['phone']])->first())){
                return array("err"=>"Số điện thoại này đã tồn tại");
            }
        }
        if(!empty($data['username'])){
            if(!empty(DB::table('admin')->where(["username"=>$data['username']])->first())){
                return array("err"=>"Tên đăng nhập này đã tồn tại");
            }
        }
        if(!empty($data['password'])){
            if(strlen($data['password'])<6){
                return array("err"=>"Mật khẩu ít nhất 6 ký tự");
            }
            $data['password'] = Hash::make($data['password']);
            unset($data['repassword']);
        }
        $data=array_merge($data,["create_at"=>strtotime('now')]);
        DB::table('admin')->insert($data);
        return array("err"=>0);
    }
    public function deleteAdmin(Request $rq){       
        $data = DB::table('admin')->whereIn("id",$rq->all())->delete();
        return array("success"=>1);
    }
    public function updateAdmin(Request $rq){
        $data = DB::table('admin')->where("id",$rq->id)->update($rq->data);
        return array("success"=>1);
    }
}
