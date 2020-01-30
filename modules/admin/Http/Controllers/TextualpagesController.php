<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\TextualPages;
/*use App\User;
use App\UserDetails;
use App\Country;
use App\State;
use App\City;*/
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
class TextualpagesController extends Controller {
    public function __construct()
    {
        $this->middleware('adminauth');
    }
    public function index(Request $request)
    {	
    	$textualpages = DB::table('textual_pages')->get()->toArray();
		return view('admin::textualpages.index', ['textualpages' => $textualpages]);
    }

    public function addtextualpage(Request $request){
        if($request->input('addtextualpage')){
            
            $this->validate($request,[
                'slugvalue' => 'required|unique:textual_pages,slug',
                'pagename' => 'required',
                'pagetitle' => 'required',
                'pagedescription' => 'required',
                'seotitle' => 'required',
                'seokeyword' => 'required',
                'seodescription' => 'required',
            ],[
                'slugvalue.required' => ' The slug name field is required.',
                'slugvalue.unique' => 'The slug field must be unque',
                'pagename.required' => ' The page name field is required.',
                'pagetitle.required' => ' The page title field is required.',
                'pagedescription.required' => ' The page description is required.',
                'seotitle.required' => 'The seo title field is required.',
                'seokeyword.required' => 'The seo keyword field is required.',
                'seodescription.required' => 'The seo description field is required.',
            ]);

            $pageimageName = null;
            if (request()->hasFile('pageimage')) {
               
                $this->validate($request,[
                    'pagename' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ],[
                    'pagename.required' => 'Please Select an valid image.',
                ]);

                $file = request()->file('pageimage');
                $pageimageName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
             


                $image_resize = Image::make($file->getRealPath());              
                $image_resize->resize(300, 300);
                $image_resize->save(public_path('/uploads/textualpages/resizepath/' .$pageimageName));

                $file->move('./public/uploads/textualpages/', $pageimageName);  
               
            }
         

            $textualpage = new TextualPages;
            $textualpage->page_name = $request->input('pagename');
            $textualpage->page_title = $request->input('pagetitle');
            $textualpage->page_description = $request->input('pagedescription');
            $textualpage->page_image = $pageimageName;
            $textualpage->seo_title = $request->input('seotitle');
            $textualpage->seo_keyword = $request->input('seokeyword');
            $textualpage->seo_description = $request->input('seodescription');
            $textualpage->slug = $request->input('slugvalue');
            if($textualpage->save()){
                $userid = $textualpage->id;
            }else{
                return back()->with('error','please try again.');
            }
            return redirect('admin/sitetextualpages')->with('success', 'Textual Page added successfully.');
      
    }
     
        return view('admin::textualpages.addtextualpage');
    }


    //edittextualpage
    public function edittextualpage(Request $request, $textualpageid){
        $textualpageinfo = TextualPages::gettextualpageinfo($textualpageid);
        
        if($request->input('edittextualpage')){
          
           $this->validate($request,[
                'slugvalue' => 'required|unique:textual_pages,slug,'.$textualpageid,
                'pagename' => 'required',
                'pagetitle' => 'required',
                'pagedescription' => 'required',
                'seotitle' => 'required',
                'seokeyword' => 'required',
                'seodescription' => 'required',
            ],[
                'slugvalue.required' => ' The slug name field is required.',
                'slugvalue.unique' => 'The slug field must be unque',
                'pagename.required' => ' The page name field is required.',
                'pagetitle.required' => ' The page title field is required.',
                'pagedescription.required' => ' The page description is required.',
                'seotitle.required' => 'The seo title field is required.',
                'seokeyword.required' => 'The seo keyword field is required.',
                'seodescription.required' => 'The seo description field is required.',
            ]);

            if (request()->hasFile('pageimage')) {
               
                $this->validate($request,[
                    'pageimage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ],[
                    'pageimage.required' => 'Please Select an valid image.',
                ]);

                $file = request()->file('pageimage');
                $pageimageName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
             


                $image_resize = Image::make($file->getRealPath());              
                $image_resize->resize(300, 300);
                $image_resize->save(public_path('/uploads/textualpages/resizepath/' .$pageimageName));

                $file->move('./public/uploads/textualpages/', $pageimageName);  
               
            }else{
                $pageimageName = $textualpageinfo['0']['page_image'];
            }


            $datauser = array(
                'page_name' => $request->input('pagename'),
                'page_title' => $request->input('pagetitle'),
                'page_description' => $request->input('pagedescription'),
                'page_image' => $pageimageName,
                'seo_title' => $request->input('seotitle'),
                'seo_keyword' => $request->input('seokeyword'),
                'seo_description' => $request->input('seodescription'),
                'slug' => $request->input('slugvalue'),
            );
            $updatedrecord = TextualPages::updatedtextualpage($textualpageid, $datauser);
            if($updatedrecord == '1'){
               return redirect('admin/sitetextualpages')->with('success', 'Textual Page Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
        }
        return view('admin::textualpages.edittextualpage', ['textualpageinfo' => $textualpageinfo]);
    }


    //deletetextualpage
    public function deletetextualpage(Request $request, $textualpageid){
        $deletedata = TextualPages::deletetextualpage($textualpageid);
        if($deletedata){
            return redirect('admin/sitetextualpages')->with('success', 'Deleted successfully.');
        }else{
            return redirect('admin/sitetextualpages')->with('error', 'Not Deleted! Please try again later!');
        }
    }

    //updatestatus
    public function updatestatus(Request $request, $textualpageid, $status){
        if($status == '1'){
            $newstatus = '0';
        }else{
            $newstatus = '1';
        }

        $newstatusdata = array(
            'status' => $newstatus,
        );
        $statusupdate = TextualPages::updatedtextualpage($textualpageid, $newstatusdata);
        
        if($statusupdate){
            return redirect('admin/sitetextualpages')->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/sitetextualpages')->with('error', 'Status not updated successfully.');
        }
    }

}


