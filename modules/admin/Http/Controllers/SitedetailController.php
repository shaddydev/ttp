<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Siteinfo;
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
class SitedetailController extends Controller {
    public function __construct()
    {
        $this->middleware('adminauth');
        //$this->middleware('/Admin/Http/Middleware/AdminMiddleware');
    }
    public function index(Request $request)
    {	
        

    }
    public function siteinfo(Request $request)
    {   
        $siteinfos = Siteinfo::viewallsiteinfo();
        //SITE LOGO
            if($request->input('submitsitelogo')){
                $sitelogoname = $siteinfos['0']['value'];
                    if (request()->hasFile('sitelogo')) {
                        $file = request()->file('sitelogo');
                        $sitelogoname = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                         


                        $image_resize = Image::make($file->getRealPath());              
                        $image_resize->resize(233, 53);
                        $image_resize->save(public_path('/uploads/siteinfo/resizepath/' .$sitelogoname));

                        $file->move('./public/uploads/siteinfo/', $sitelogoname);  
                       
                    }else{
                        $sitelogoname = $siteinfos['0']['value'];
                    }

                     $data = array(
                        'value' => $sitelogoname,
                     );
                     $logoid = 1;
                     $updatedrecord = Siteinfo::updatesiteinfo($logoid, $data);
                        if($updatedrecord == '1'){
                           return redirect('admin/siteinfo')->with('success', 'Site Logo Updated  successfully.');
                        }else{
                             return back()->with('error','please try again.');
                        }


            }

            //EMAIL
            if($request->input('updatesiteemail')){
                $this->validate($request,[
                    'siteemail' => 'required|email',
                ],[
                    'siteemail.required' => ' The Site Email field is required.',
                ]);

                $emailid = 6;
                $emaildata = array(
                    'value' => $request->input('siteemail'),
                );
                $updatedrecord = Siteinfo::updatesiteinfo($emailid, $emaildata);
                    if($updatedrecord == '1'){
                       return redirect('admin/siteinfo')->with('success', 'Site Email Updated  successfully.');
                    }else{
                         return back()->with('error','please try again.');
                    }


            }

            //querynumber
            if($request->input('updatesitequerynumber')){
                $this->validate($request,[
                    'sitequerynumber' => 'required',
                ],[
                    'sitequerynumber.required' => ' The Site Query Number field is required.',
                ]);

                $querynumberid = 2;
                $querydata = array(
                    'value' => $request->input('sitequerynumber'),
                );
                $updatedrecord = Siteinfo::updatesiteinfo($querynumberid, $querydata);
                    if($updatedrecord == '1'){
                       return redirect('admin/siteinfo')->with('success', 'Site Query Number Updated  successfully.');
                    }else{
                         return back()->with('error','please try again.');
                    }


            }

            //mobilenumber
            if($request->input('updatesitemobilenumber')){
                $this->validate($request,[
                    'sitemobilenumber' => 'required',
                ],[
                    'sitemobilenumber.required' => ' The Site Mobile Number field is required.',
                ]);

                $mobilenumberid = 3;
                $mobiledata = array(
                    'value' => $request->input('sitemobilenumber'),
                );
                $updatedrecord = Siteinfo::updatesiteinfo($mobilenumberid, $mobiledata);
                    if($updatedrecord == '1'){
                       return redirect('admin/siteinfo')->with('success', 'Site Mobile Number Updated  successfully.');
                    }else{
                         return back()->with('error','please try again.');
                    }


            }

            //siteaddress
             if($request->input('updatesiteaddress')){
                $this->validate($request,[
                    'siteaddress' => 'required',
                ],[
                    'siteaddress.required' => ' The Site Address field is required.',
                ]);

                $siteaddressid = 5;
                $siteaddressdata = array(
                    'value' => $request->input('siteaddress'),
                );
                $updatedrecord = Siteinfo::updatesiteinfo($siteaddressid, $siteaddressdata);
                    if($updatedrecord == '1'){
                       return redirect('admin/siteinfo')->with('success', 'Site Address Updated  successfully.');
                    }else{
                         return back()->with('error','please try again.');
                    }


            }


            //footertext
            if($request->input('updatesitefootertext')){
                $this->validate($request,[
                    'sitefootertext' => 'required',
                ],[
                    'sitefootertext.required' => ' The Site Footer Text is required.',
                ]);

                $sitefootertid = 4;
                $sitefooterdata = array(
                    'value' => $request->input('sitefootertext'),
                );
                $updatedrecord = Siteinfo::updatesiteinfo($sitefootertid, $sitefooterdata);
                    if($updatedrecord == '1'){
                       return redirect('admin/siteinfo')->with('success', 'Site Footer Text Updated  successfully.');
                    }else{
                         return back()->with('error','please try again.');
                    }


            }


            if($request->input('updatesocialmedialinks')){
                    $facebooklinkdata = array(
                        'value' => $request->input('facebooklink'),
                    );
                    $facebooklinkid = 7;

                    $facebooklinkrecord = Siteinfo::updatesiteinfo($facebooklinkid, $facebooklinkdata);
                    if($facebooklinkrecord == '1'){
                        $twitterlinkdata = array(
                            'value' => $request->input('twitterlink'),
                        );
                        $twitterlinkid = 8;

                        $twitterlinkrecord = Siteinfo::updatesiteinfo($twitterlinkid, $twitterlinkdata);
                        if($twitterlinkrecord == '1'){
                            $instagramlinkdata = array(
                                'value' => $request->input('instagramlink'),
                            );
                            $instagramlinkid = 9;

                            $instagramlinkrecord = Siteinfo::updatesiteinfo($instagramlinkid, $instagramlinkdata);
                            if($instagramlinkrecord == '1'){
                                $pinterestlinkdata = array(
                                    'value' => $request->input('pinterestlink'),
                                );
                                $pinterestlinkid = 10;

                                $pinterestlinkrecord = Siteinfo::updatesiteinfo($pinterestlinkid, $pinterestlinkdata);
                                if($pinterestlinkrecord == '1'){
                                   return redirect('admin/siteinfo')->with('success', 'Site SOcial media links are Updated  successfully.');
                                }else{
                                     return back()->with('error','please try again.');
                                }

                            }else{
                                 return back()->with('error','please try again.');
                            }
                        }else{
                                 return back()->with('error','please try again.');
                        }
                    }else{
                                 return back()->with('error','please try again.');
                    }

            }

        return view('admin::Sitedetails.updatesiteinfos', ['siteinfos' => $siteinfos]);
    }

}