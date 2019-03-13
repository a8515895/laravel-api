<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Library\MyFunction;
use DB;
use App\M_admin;
class Test extends Controller
{
    private $myfunction;
    public function __construct(){
        $this->myfunction = new MyFunction;
    }
    public function index(){
        return $this->myfunction->test();
    }
}
