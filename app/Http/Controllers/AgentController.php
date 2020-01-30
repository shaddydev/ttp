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

class AgentController extends Controller {
    public function index(){
        if(Auth::check()){
            if(Auth::user()->hasRole('agent')){
                return redirect('/home');
			}else { 
                return redirect('agent/login');
            }
        }
        return redirect('agent/login');
}
	
}
