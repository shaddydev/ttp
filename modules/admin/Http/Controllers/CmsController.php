<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Testimonials;
use App\Banner;
use App\Welcomedata;
use App\Homeslider;
use App\Features;
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
class CmsController extends Controller {
    public function __construct()
    {
        $this->middleware('adminauth');
    }
    public function index(Request $request)
    {	
        

    }
    public function testimonials()
    {   
        $testimonials = Testimonials::viewalltestimonials();
        return view('admin::Cms.viewtestimonials', ['testimonials' => $testimonials]);
    }

    public function addtestimonial(Request $request){
        if($request->input('addtestimonial')){
          
        $this->validate($request,[
            'userimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'username' => 'required|unique:testimonial',
            'designation' => 'required',
            'description' => 'required',
        ],[
            'userimage.required' => 'Please Select an valid image.',
            'username.required' => ' The username field is required.',
            'designation.required' => 'The designation field is required.',
            'description.required' => ' The Short Description is required.',
        ]);
        
        //image
   
        $fileName = null;
        if (request()->hasFile('userimage')) {
            $file = request()->file('userimage');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(130, 130);
            $image_resize->save(public_path('/uploads/testimonials/resizepath/' .$fileName));

            $file->move('./public/uploads/testimonials/', $fileName);  
           
        }



        $Testimonials = new Testimonials;
         $Testimonials->image = $fileName;
         $Testimonials->username = $request->input('username');
         $Testimonials->designation = $request->input('designation');
         $Testimonials->description = $request->input('description');
            if($Testimonials->save()){
                $testimonialid = $Testimonials->id;
            }else{
                 return back()->with('error','please try again.');
            }
            return redirect('admin/testimonials')->with('success', 'Testimonial added successfully.');
        }
        return view('admin::Cms.addtestimonial');
    }


    public function edittestimonial(Request $request, $testimonialid){
        $testimonialdata = Testimonials::viewtestimonialinfo($testimonialid);
        if($request->input('edittestimonial')){
               $this->validate($request,[
                    'username' => 'required|unique:testimonial,username,'.$testimonialid,
                    'designation' => 'required',
                    'description' => 'required',
                ],[
                    'username.required' => ' The username field is required.',
                    'designation.required' => 'The designation field is required.',
                    'description.required' => ' The Description is required.',
                ]);

               //for image
               //$fileName = null;
               $fileName = $testimonialdata['0']['image'];
                if (request()->hasFile('userimage')) {
                    $file = request()->file('userimage');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(300, 300);
                        $image_resize->save(public_path('/uploads/testimonials/resizepath/' .$fileName));

                    $file->move('./public/uploads/testimonials/', $fileName);   
                }else{
                    $fileName = $testimonialdata['0']['image'];
                }


   
         $data = array(
            'image' => $fileName,
            'username' => $request->input('username'),
            'designation' => $request->input('designation'),
            'description' => $request->input('description'),
            
         );
         $updatedrecord = Testimonials::updatetestimonial($testimonialid, $data);
            if($updatedrecord == '1'){
               return redirect('admin/testimonials')->with('success', 'Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
            
        }
        return view('admin::Cms.edittestimonials', ['testimonialinfo'=>$testimonialdata]);
    }



    //delete services
    public function deletetestimonials(Request $request, $testimonialid){
        $deletedata = Testimonials::deletetestimonials($testimonialid);
        if($deletedata){
            return redirect('admin/testimonials')->with('success', 'Deleted successfully.');
        }else{
            return redirect('admin/testimonials')->with('error', 'Not Deleted! Please try again later!');
        }
    }


    //banneredit
    public function banneredit(Request $request){
        $bannerdata = Banner::viewbannerinfo();
         if($request->input('editbannerinfo')){
               

               //for image
               //$fileName = null;
               $fileName = $bannerdata['0']['banner_image'];
                if (request()->hasFile('bannerimage')) {
                    $file = request()->file('bannerimage');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(1352, 238);
                        $image_resize->save(public_path('/uploads/banner/resizepath/' .$fileName));

                    $file->move('./public/uploads/banner/', $fileName);   
                }else{
                    $fileName = $bannerdata['0']['banner_image'];
                }


   
         $data = array(
            'banner_image' => $fileName,
            'banner_url' => $request->input('bannerurl'),  
         );
         $updatedrecord = Banner::updatebanner($data);
            if($updatedrecord == '1'){
               return redirect('admin/banners')->with('success', 'Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
            
        }
        return view('admin::Cms.editbanner', ['bannerinfo'=>$bannerdata]);
    }

   
   public function editwelcomedata(Request $request){
        $Welcomedata = Welcomedata::viewwelcomedata();
        if($request->input('editwelcomedata')){
                $this->validate($request,[
                    'weltitle' => 'required',
                    'welmsg' => 'required',
                    'weldesc' => 'required',
                    'welshortdesc' => 'required',
                ],[
                    'weltitle' => 'The welcome title field is required',
                    'welmsg.required' => ' The welcome message field is required.',
                    'weldesc.required' => 'The welcome description field is required.',
                    'welshortdesc.required' => 'The welcome description field is required.',
                ]);


         $data = array(
            'welcome_title' => $request->input('weltitle'),
            'welcome_message' => $request->input('welmsg'),
            'welcome_description' => $request->input('weldesc'),  
            'welcome_short_description' => $request->input('welshortdesc'),  
         );
         $updatedrecord = Welcomedata::updatewelcomedata($data);
            if($updatedrecord == '1'){
               return redirect('admin/welcomedata')->with('success', 'Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
            
        }
        return view('admin::Cms.editwelcomedata', ['welcomeinfo'=>$Welcomedata]);
   }



   public function homesliders(){
        $homesliders = Homeslider::viewallhomesliders();
        return view('admin::Cms.viewhomesliders', ['homesliders' => $homesliders]);
   }

    public function addhomeslider(Request $request){
        if($request->input('addhomeslider')){
          
        $this->validate($request,[
            'sliderimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           // 'url' => 'required',
        ],[
            'sliderimage.required' => 'Please Select an valid image.',
          //  'url.required' => ' The url field is required.',
        ]);
        
        //image
   
        $fileName = null;
        if (request()->hasFile('sliderimage')) {
            $file = request()->file('sliderimage');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(1557, 845);
            $image_resize->save(public_path('/uploads/homeslider/resizepath/' .$fileName));

            $file->move('./public/uploads/homeslider/', $fileName);  
           
        }



        $Homeslider = new Homeslider;
         $Homeslider->image = $fileName;
         $Homeslider->url = $request->input('url');
            if($Homeslider->save()){
                $homesliderid = $Homeslider->id;
            }else{
                 return back()->with('error','please try again.');
            }
            return redirect('admin/homesliders')->with('success', 'Testimonial added successfully.');
        }
        return view('admin::Cms.addhomeslider');
    }

    public function edithomeslider(Request $request, $homesliderid){
        $homesliderdata = Homeslider::viewhomesliderinfo($homesliderid);
        if($request->input('edithomeslider')){
              

               //for image
               //$fileName = null;
               $fileName = $homesliderdata['0']['image'];
                if (request()->hasFile('sliderimage')) {
                    $file = request()->file('sliderimage');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(1557, 845);
                        $image_resize->save(public_path('/uploads/homeslider/resizepath/' .$fileName));

                    $file->move('./public/uploads/homeslider/', $fileName);   
                }else{
                    $fileName = $homesliderdata['0']['image'];
                }


   
         $data = array(
            'image' => $fileName,
            'url' => $request->input('url'),
         );
         $updatedrecord = Homeslider::updatehomeslider($homesliderid, $data);
            if($updatedrecord == '1'){
               return redirect('admin/homesliders')->with('success', 'Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
            
        }
        return view('admin::Cms.edithomeslider', ['homesliderinfo'=>$homesliderdata]);
    }

    public function deletehomeslider(Request $request, $homesliderid){
        $deletedata = Homeslider::deletehomeslider($homesliderid);
        if($deletedata){
            return redirect('admin/homesliders')->with('success', 'Deleted successfully.');
        }else{
            return redirect('admin/homesliders')->with('error', 'Not Deleted! Please try again later!');
        }
    }



   public function features(){
        $features = Features::viewallfeatures();
        return view('admin::Cms.viewfeatures', ['features' => $features]);
   }

    public function addfeatures(Request $request){
        if($request->input('addfeatures')){
          
        $this->validate($request,[
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|unique:features',
            'description' => 'required',
        ],[
            'logo.required' => 'Please Select an valid logo.',
            'title.required' => ' The Title field is required.',
            'description.required' => ' The Description field is required.',
        ]);
        
        //image
   
        $fileName = null;
        if (request()->hasFile('logo')) {
            $file = request()->file('logo');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(32, 19);
            $image_resize->save(public_path('/uploads/features/resizepath/' .$fileName));

            $file->move('./public/uploads/features/', $fileName);  
           
        }



        $Features = new Features;
         $Features->logo = $fileName;
         $Features->title = $request->input('title');
         $Features->description = $request->input('description');
            if($Features->save()){
                $featuresid = $Features->id;
            }else{
                 return back()->with('error','please try again.');
            }
            return redirect('admin/features')->with('success', 'Features added successfully.');
        }
        return view('admin::Cms.addfeatures');
    }

    public function editfeature(Request $request, $featureid){
        $featuredata = Features::viewfeatureinfo($featureid);
        if($request->input('editfeature')){
               $this->validate($request,[
                    'title' => 'required|unique:features,title,'.$featureid,
                    'description' => 'required',
                ],[
                    'title.required' => ' The title field is required.',
                    'description.required' => ' The Description is required.',
                ]);

               //for image
               //$fileName = null;
               $fileName = $featuredata['0']['logo'];
                if (request()->hasFile('logo')) {
                    $file = request()->file('logo');
                    $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(32, 19);
                        $image_resize->save(public_path('/uploads/features/resizepath/' .$fileName));

                    $file->move('./public/uploads/features/', $fileName);   
                }else{
                    $fileName = $featuredata['0']['logo'];
                }


   
         $data = array(
            'logo' => $fileName,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            
         );
         $updatedrecord = Features::updatefeature($featureid, $data);
            if($updatedrecord == '1'){
               return redirect('admin/features')->with('success', 'Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
            
        }
        return view('admin::Cms.editfeature', ['featureinfo'=>$featuredata]);
    }


    public function deletefeature(Request $request, $featureid){
        $deletedata = Features::deletefeature($featureid);
        if($deletedata){
            return redirect('admin/features')->with('success', 'Deleted successfully.');
        }else{
            return redirect('admin/features')->with('error', 'Not Deleted! Please try again later!');
        }
    }


}

