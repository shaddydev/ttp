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

use App\Packages;
use App\PackageDetails;

/**
 * Description of HomeController
 *
 * @author Abhishek
 */
class PackagesController extends Controller {

    public function __construct()
    {
        $this->middleware('adminauth');
    }


    public function index(Request $request)
    {	
        $packages = Packages::orderBy('id','DESC')->paginate(10);
        return view('admin::packages.index',['packages'=>$packages]);

    }


    public function create(Request $request){
    	if($request->input('create')){
                $this->validate($request,[
                    'title' => 'required|unique:packages'
                ]);
    		$package = new Packages;
	        $package->title = $request->input('title');
			if($package->save()){
                return redirect('admin/packages/update/'.$package->id)->with('success', 'Package successfully created. Now add more features into the package');
    		}else{
    			return back()->with('error','please try again.');
    		}
         }
    	return view('admin::packages.create');
    }

    public function update(Request $request, $id){
        $package = Packages::with('details')->where('id',$id)->first();
        $fix_services = DB::table('portal_fix_services')->get();
        $airlines = DB::table('airlines')->get();
        if($request->input('update')){
                $this->validate($request,[
                    'title' => 'required|unique:packages'
                ]);
            $package->title = $request->input('title');
			if($package->save()){
                return redirect('admin/packages/update/'.$package->id)->with('success', 'Package title successfully updated');
    		}else{
    			return back()->with('error','please try again.');
    		}
         }
        return view('admin::packages.update',['package'=>$package,'fix_services'=>$fix_services,'airlines'=>$airlines]);
    }


    public function updatestatus(Request $request, $id, $statusid){
        $package = Packages::find($id);
        $package->status = $statusid;
        if($package->save()){
            return redirect('admin/packages')->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/packages')->with('error', 'Status not updated successfully.');
        }
    }

    //delete user
    public function delete(Request $request, $id){
        $package = Packages::find($id);
        if($package){
            if($package->delete()){
                return redirect('admin/packages')->with('success', 'Deleted successfully.');
            }else{
                return redirect('admin/packages')->with('error', 'Not Deleted! Please try again later!');
            }
        }else{
            return redirect('admin/packages')->with('error', 'Not Deleted! Please try again later!');
        }
    }


}

