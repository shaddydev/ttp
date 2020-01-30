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
use File;
use Excel;
use DB;
/**
 * Description of IndexController
 *
 * @author ABHISHEK@PANINDIA
 */

class AjaxController extends Controller {
    
    public function getstatelist(Request $request){
        $country_id = $request->input('country_id');
        $state = DB::table("states")->where('country_id',$country_id)->orderBy('name', 'ASC')->pluck("name","id");
        $selectBox="";
        foreach($state as $key=>$value){
            $selectBox .= '<option value="'.$key.'" >'.$value.'</option>';
        }
        echo $selectBox;
        
    }

    public function getcitylist(Request $request){
         $state_id = $request->input('state_id');
         $city = DB::table("cities")->where('state_id',$state_id)->orderBy('name', 'ASC')->pluck("name","id");
         $selectBox="";
        foreach($city as $key=>$value){
            $selectBox .= '<option value="'.$key.'" >'.$value.'</option>';
        }
        echo $selectBox;
    }

    public function updatesettings(Request $request){
        $id = (int)$request->input('api_name');
        DB::table('api_settings')
            ->update(['status' => 0]);
        DB::table('api_settings')
        ->where('id', $id)
        ->update(['status' => 1]);
        echo 'done';
   }

   public function updatelcc(Request $request){
        $id = (int)$request->input('index');
        DB::table($request->input('table'))
        ->where('id',$id)
        ->update(['has_lcc' => $request->input('value')]);
        echo 'done';
}
	
}
