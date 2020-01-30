<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Service;
use App\User;
use App\UserDetails;
use App\Country;
use App\State;
use App\City;
use DB;
use Excel;
use App\Vendors\Hotals\Sabre;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;
/**
 * Description of HomeController
 *
 * @author Abhishek
 */
class ServicesController extends Controller {
    public function __construct()
    {
        $this->middleware('adminauth');
    }
    public function index(Request $request)
    {	
        // /echo "url ==".url('/');die();
       // $users = User::All();
        $services = DB::table('services')->get();
        return view('admin::services.index',['services'=>$services]);

    }

    public function addservice(Request $request){
        //addservice
        if($request->input('addservice')){
          $this->validate($request,[
            'Serviceimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|unique:services',
            'desc' => 'required',
            'shortdesc' => 'required',
        ],[
            'Serviceimage.required' => 'Please Select an valid image.',
            'title.required' => ' The Title field is required.',
            'desc.required' => 'The Description field is required.',
            'shortdesc.required' => ' The Short Description is required.',
        ]);
        
        //image
   
        $fileName = null;
        if (request()->hasFile('Serviceimage')) {
            $file = request()->file('Serviceimage');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
             


            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(300, 300);
            $image_resize->save(public_path('/uploads/service/resizepath/' .$fileName));

            $file->move('./public/uploads/service/', $fileName);  
            /*$destinationPath = public_path('/public/uploads/service/resizepath');
            $thumb_img = Image::make($photo->getRealPath())->resize(60, 36);
            $thumb_img->save($destinationPath.'/'.$imagename,80);*/

        }



/*        $photo = $request->file('photo');
        $imagename = time().'.'.$photo->getClientOriginalExtension(); 
   
        $destinationPath = public_path('/thumbnail_images');
        $thumb_img = Image::make($photo->getRealPath())->resize(100, 100);
        $thumb_img->save($destinationPath.'/'.$imagename,80);
                    
        $destinationPath = public_path('/normal_images');
        $photo->move($destinationPath, $imagename);
        */



        //echo"<pre>";print_r($imageadd);die();

        $services = new Service;
         $services->image = $fileName;
         $services->title = $request->input('title');
         $services->description = $request->input('desc');
         $services->longdescription = $request->input('shortdesc');
         $services->status = 1;
            if($services->save()){
                $serviceid = $services->id;
            }else{
                 return back()->with('error','please try again.');
            }
            return redirect('admin/services')->with('success', 'Services added successfully.');
        }//echo "kfdqqq";die();
       return view('admin::services.addservices');
    }

    //update status
    public function updatestatus(Request $request, $serviceid, $status){
        if($status == '1'){
            $newstatus = '0';
        }else{
            $newstatus = '1';
        }

        $statusupdate = Service::updatestatus($serviceid, $newstatus);
        
        if($statusupdate){
            return redirect('admin/services')->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/services')->with('error', 'Status not updated successfully.');
        }
    }

    //delete services
    public function deleteservices(Request $request, $serviceid){
        $deletedata = Service::deleteservices($serviceid);
        if($deletedata){
            return redirect('admin/services')->with('success', 'Deleted successfully.');
        }else{
            return redirect('admin/services')->with('error', 'Not Deleted! Please try again later!');
        }
    }

    //editservices
    public function editservices(Request $request, $serviceid){
        $servicedata = Service::viewserviceinfo($serviceid);
        if($request->input('editservice')){
               $this->validate($request,[
                    'title' => 'required|unique:services,title,'.$serviceid,
                    'desc' => 'required',
                    'shortdesc' => 'required',
                ],[
                    'title.required' => ' The Title field is required.',
                    'desc.required' => 'The Description field is required.',
                    'shortdesc.required' => ' The Short Description is required.',
                ]);

               //for image
               //$fileName = null;
               $fileName = $servicedata['0']['image'];
                if (request()->hasFile('Serviceimage')) {
                    $file = request()->file('Serviceimage');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(300, 300);
                        $image_resize->save(public_path('/uploads/service/resizepath/' .$fileName));

                    $file->move('./public/uploads/service/', $fileName);   
                }else{
                    $fileName = $servicedata['0']['image'];
                }


       // $services = new Service;
     /*    $services->image = $request->input('Serviceimage');
         $services->title = $request->input('title');
         $services->description = $request->input('desc');
         $services->longdescription = $request->input('shortdesc');
         $services->status = 1;*/
         $data = array(
            'image' => $fileName,
            'title' => $request->input('title'),
            'description' => $request->input('desc'),
            'longdescription' => $request->input('shortdesc'),
            'status' => 1,
         );
         $updatedrecord = Service::updateservice($serviceid, $data);
            if($updatedrecord == '1'){
               return redirect('admin/services')->with('success', 'Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
            
        }//ech


        ///echo "<pre>";print_r($serviceinfo);die();
        return view('admin::services.editservices', ['serviceinfo'=>$servicedata]);
    }

}

