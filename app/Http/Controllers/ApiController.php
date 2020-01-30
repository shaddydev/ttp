<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

use App\TBO;
use App\ApiSettings;

/**
 * Description of IndexController
 *
 * @author ABHISHEK@PANINDIA
 */

class ApiController extends Controller {
    public function login(Request $request){
        $ip = "192.168.10.10";
        $TBO = new TBO;
        $auth = json_decode($TBO->authenticate($ip));
        if($auth->Status == 1  &&  $auth->TokenId!=='') {
            $api = $request->input('name');
            $apiSettings = ApiSettings::where('key_val',$api)->update(['auth_key' =>$auth->TokenId]);
            echo json_encode('Token updated');
        }
    }
}
