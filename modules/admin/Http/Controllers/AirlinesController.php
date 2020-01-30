<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

use App\Airlines;


/**
 * Description of HomeController
 *
 * @author Abhishek
 */
class AirlinesController extends Controller {

    public function __construct()
    {
        $this->middleware('adminauth');
    }

    public function index(Request $request)
    {	
        if($request->input('addfilter')){
                $airlinename = $request->input('airlinename');
                $airlinecode = $request->input('airlinecode');
                $status = $request->input('status');
            }else{
                if(app('request')->input()){
                       $airlinename = app('request')->input('airlinename');
                        $airlinecode = app('request')->input('airlinecode');
                        $status = app('request')->input('status');
                }else{
                    $airlinename = '';
                    $airlinecode = '';
                    $status = '';
                }
            }

            if($airlinename == ''){
                $condition1 = array();
            }else{
                $condition1 = array(
                   'name' => $airlinename
                );
            }
            if($airlinecode == ''){
                $condition2 = array();
            }else{
                $condition2 = array(
                   'code' => $airlinecode
                );
            }
            if($status == ''){
                $condition3 = array();
            }else{
                $condition3 = array(
                  'status'  => $status
                );
            }
        DB::enableQueryLog();
        $airlines = Airlines::where($condition1)->where($condition2)->where($condition3)->orderBy('name','ASC')->paginate(10);
        /*$query = DB::getQueryLog();
$query = end($query);
print_r($query);die;*/
        $allairlines = Airlines::orderBy('name','ASC')->paginate();
        return view('admin::airlines.index',['airlines'=>$airlines, 'allairlines'=>$allairlines]);
    }

    public function create(Request $request){
    	if($request->input('create')){
                $this->validate($request,[
                    'name' => 'required|unique:airlines',
                    'code' => 'required|unique:airlines',
                    'logo' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
                ]);
                $airline = new Airlines;
                $airline->name = $request->input('name');
                $airline->code = $request->input('code');
                $airline->status = 1;
                if (request()->hasFile('logo')) {
                    $file = request()->file('logo');
                    $logo = './public/images/airlines/'.$airline->code.'.gif';
                    $file->move('./public/images/airlines/',$airline->code.'.gif');   
                    $image_resize = Image::make($logo);
                    $image_resize->resize(30, NULL, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $image_resize->save(public_path('images/airlines/'.$airline->code.'.gif'));
                    $airline->logo = $airline->code;
                }

			if($airline->save()){
                return redirect('admin/airlines')->with('success', 'Airline successfully created. Now add more features into the package');
    		}else{
    			return back()->with('error','please try again.');
    		}
         }
    	return view('admin::airlines.create');
    }

    public function update(Request $request,$id){
        $airline = Airlines::find($id);
    	if($request->input('update')){
                $this->validate($request,[
                    'name' => 'required|unique:airlines,name'. $id,
                    'code' => 'required|unique:airlines,code'. $id,
                    'logo' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
                ]);
                $airline->name = $request->input('name');
                $airline->code = $request->input('code');
                if (request()->hasFile('logo')) {
                    $file = request()->file('logo');
                    $logo = './public/images/airlines/'.$airline->code.'.gif';
                    $file->move('./public/images/airlines/',$airline->code.'.gif');   
                    $image_resize = Image::make($logo);
                    $image_resize->resize(30, NULL, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $image_resize->save(public_path('images/airlines/'.$airline->code.'.gif'));
                    $airline->logo = $airline->code;
                }

			if($airline->save()){
                return redirect('admin/airlines')->with('success', 'Airline successfully created. Now add more features into the package');
    		}else{
    			return back()->with('error','please try again.');
    		}
         }
    	return view('admin::airlines.update',['airline'=>$airline]);
    }

    public function updatestatus(Request $request, $id, $statusid){
        $airline = Airlines::find($id);
        $airline->status = $statusid;
        if($airline->save()){
            return redirect('admin/airlines')->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/airlines')->with('error', 'Status not updated successfully.');
        }
    }


    public function delete(Request $request, $id){
        $airline = Airlines::find($id);
        if($airline){
            if($airline->delete()){
                return redirect('admin/airlines')->with('success', 'Deleted successfully.');
            }else{
                return redirect('admin/airlines')->with('error', 'Not Deleted! Please try again later!');
            }
        }else{
            return redirect('admin/airlines')->with('error', 'Not Deleted! Please try again later!');
        }
    }


}

