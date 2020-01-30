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
class PackageDetailController extends Controller {

    public function __construct()
    {
        $this->middleware('adminauth');
    }

    public function create(Request $request,$id){

        $package = Packages::with('details')->where('id',$id)->first();
        $fix_services = DB::table('portal_fix_services')->orderBy('display_title', 'ASC')->pluck("display_title","id");
        $airlines = DB::table('airlines')->orderBy('name', 'ASC')->pluck("name","id");

    	if($request->input('create')){
                $this->validate($request,[
                    'fix_service_id' => 'required',
                    'commission' => 'required|min:1||max:100',
                    'fare_type' => 'required',
                ]);

                $package = new PackageDetails;
                $package->package_id = $id;
                $package->fix_service_id = $request->input('fix_service_id');
                $package->airline = $request->input('airline');
                $package->commission = $request->input('commission');
                $package->commission_type =1;
                $package->fare_type = $request->input('fare_type');
			if($package->save()){
                return redirect('admin/packages/update/'.$id)->with('success', 'Package successfully updated.');
    		}else{
    			return back()->with('error','please try again.');
    		}
         }
         
    	return view('admin::package-detail.create',['package'=>$package,'fix_services'=>$fix_services,'airlines'=>$airlines]);
    }

    public function update(Request $request, $id){
        $package = PackageDetails::with('package')->where('id',$id)->first();
        $fix_services = DB::table('portal_fix_services')->orderBy('display_title', 'ASC')->pluck("display_title","id");
        $airlines = DB::table('airlines')->orderBy('name', 'ASC')->pluck("name","id");
        if($request->input('update')){
                $this->validate($request,[
                    'fix_service_id' => 'required',
                    'commission' => 'required|min:1||max:100',
                    'fare_type' => 'required',
                ]);
                $package->fix_service_id = $request->input('fix_service_id');
                $package->airline = ($request->input('airline'))?$request->input('airline'):NULL;
                $package->commission = $request->input('commission');
                $package->commission_type = 1;
                $package->fare_type = $request->input('fare_type');
            if($package->save()){
                return redirect('admin/packages/update/'.$package->package->id)->with('success', 'Package successfully updated.');
            }else{
                return back()->with('error','please try again.');
            }
        }
        return view('admin::package-detail.update',['package'=>$package,'fix_services'=>$fix_services,'airlines'=>$airlines]);
    }

    public function updatestatus(Request $request, $id, $statusid){
        $package = PackageDetails::find($id);
        $package->status = $statusid;
        if($package->save()){
            return redirect('admin/packages/update/'.$package->package_id)->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/packages/update/'.$package->package_id)->with('error', 'Status not updated successfully.');
        }
    }

    //delete user
    public function delete(Request $request, $id){
        $package = PackageDetails::find($id);
        if($package){
            if($package->delete()){
                return redirect('admin/packages/update/'.$package->package_id)->with('success', 'Deleted successfully.');
            }else{
                return redirect('admin/packages/update/'.$package->package_id)->with('error', 'Not Deleted! Please try again later!');
            }
        }else{
            return redirect('admin/packages/update/'.$package->package_id)->with('error', 'Not Deleted! Please try again later!');
        }
    }



}

