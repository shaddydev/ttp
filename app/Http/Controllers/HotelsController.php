<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HotelsCity;
use App\TBO;
use App\ApiSettings;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
class HotelsController extends Controller
{
    //
    /**
     * Load result page 
     * @method 
     * 
     */
    public function index(Request $request)
    {  
        return view('hotels.hotelslist');
    }
    /**
     * Load Hotel result page
     * @method index
     * @param null
     */
    public function search(Request $request)
    {    
       
        $k =0;
        $a1 = explode(',',$request->NoOfChild);
        $a2 = explode(',',$request->ChildAge);
        $a3 = array();
        $a4 = array();
        
        for($i =0; $i < count($a1); $i++){
          
        for($j =0; $j<$a1[$i]; $j++){
            $a3[] = $a2[$k];
                 $k++;
        }
          array_push($a4, $a3);
          $a3 = array();
        }

         if(count(array_filter($a4))>0){
            for($i=0; $i< count(explode(',',$request->NoOfAdults)); $i++)
            {   
               
                for ($k =  0; $k<count(explode(',',$request->NoOfChild));$k++){
                    $age[] = explode(',',$request->ChildAge)[$k];
                }
               //  print_r (explode(',',$request->ChildAge));exit;
                $adult[] = array('NoOfAdults'=> explode(',',$request->NoOfAdults)[$i],
                                 'NoOfChild' => explode(',',$request->NoOfChild)[$i],
                                 'ChildAge' => $a4[$i],
                                );
                                        
            }
            }else{
                for($i=0; $i< count(explode(',',$request->NoOfAdults)); $i++)
                {   
                    $adult[] = array('NoOfAdults'=> explode(',',$request->NoOfAdults)[$i],
                                    'NoOfChild' => explode(',',$request->NoOfChild)[$i],
                                    'ChildAge' => null,
                                    );
                                            
                }
            }
     
        //print_r($adult);exit;
         $ip = "192.168.10.10";
         $TBO = new TBO;
         $apiSettings = ApiSettings::where('status',1)->first();
         //print_r($apiSettings->auth_key); exit;
        $data = array( "EndUserIp"=>$ip,
                       "TokenId"=> $apiSettings->auth_key,
                       "CheckInDate" =>date('d/m/Y',strtotime($request->checkIndate)), // '29/08/2019'
                       "NoOfNights" =>$request->NoOfNights,
                       "CountryCode" => $request->countryid,//'NL',//,
                       "CityId" => $request->cityid,//'14621',//'',
                       "ResultCount"=> null,
                       "PreferredCurrency" => 'INR',
                       "GuestNationality" => $request->countryid,
                       "NoOfRooms"=> count(explode(',',$request->NoOfAdults)),
                       "NoOfAdults"=>count(explode(',',$request->NoOfAdults)),
                       "RoomGuests" => $adult,
                       "MaxRating" => 5,
                       "MinRating" =>0,
                       "ReviewScore" =>null,
                       "IsNearBySearchAllowed" => false);
        //echo json_encode($data); exit;
        return $TBO->searchHotel(($data),['postData'=>$request->all()]);    
           
       
    }
    /**
     *  Get city and country name
     *  @method getcityListJson
     *  @param null
     */
    public function getcityListJson(Request $request){
        
        $term = $request->input('keys');
       
        $airports = HotelsCity::where('Destination', 'LIKE', '' . $term . '%')->orwhere('country', 'LIKE', '' . $term . '%')->orwhere('countrycode', 'LIKE', '' . $term . '%')->orwhere('StateProvinceCode', 'LIKE', '' . $term . '%')->limit(10)->get();
        echo json_encode($airports);
        die();
    }
    /**
     * Get Hotel Detail 
     * @method hotelDetail
     * @param null
     */
    public function hotelDetail(Request $request)
    {  
       return view('hotels.hoteldetail');
    }

    /**
     * Get JSON response data 
     * @method detail
     * @param null
     */
    public function detail(Request $request)
    {
        
        //print_r($request->all());exit;
        $ip = "192.168.10.10";
        $TBO = new TBO;
        $apiSettings = ApiSettings::where('status',1)->first();
        $data = array( "EndUserIp"=>  $ip,
                      "TokenId"   =>  $apiSettings->auth_key,
                      "ResultIndex"=> $request->ResultIndex,
                      "HotelCode" =>  $request->HotelCode,
                      "TraceId" =>    $request->TraceId);
                   
       return $TBO->hotelDetail(($data),['postData'=>$request->all()]);  
    }

    // Room Info
    public function HotelRoom(Request $request)
    {
        
         $ip = "192.168.10.10";
         $TBO = new TBO;
         $apiSettings = ApiSettings::where('status',1)->first();
         $data = array( "EndUserIp"=>  $ip,
                        "TokenId"  =>  $apiSettings->auth_key,
                       "ResultIndex"=> $request->ResultIndex,
                       "HotelCode"  => $request->HotelCode,
                       "TraceId"    => $request->TraceId);
            //print_r($$TBO->hotelRooms(($data))); exit;        
        return $TBO->hotelRooms(($data),['postData'=>$request->all()]);  
    }

    /**
     * Load Room Detail page
     * @method roomDetail
     * @param null
     */
    public function hotelCheckout(Request $request)
    { 
        
        
        $corporate_service_charge= 0;
        if(!Auth::guest() && Auth::user()->hasRole('agent')){
            $package_details =  DB::select("SELECT pd.commission,pd.fare_type,pd.commission_type,a.code from package_detail as pd left join user_package as up on pd.package_id = up.package_id left join airlines as a on a.id = pd.airline WHERE up.user_id = ".Auth::user()->id." and up.fix_service_id = 1 and pd.fix_service_id = 1");
            $corporate_service_charge = Auth::user()->user_details->service_charge;
        }
        return view('hotels.hotel_checkout',['corporate_service_charge'=> $corporate_service_charge]);
    }

    /**
     * Send data to API 
     * @method getRoomDetail
     * @param null
     */
    public function RoomDetail(Request $request)
    { 
        
        
        Session::put('querystring',$request->all());
        $arr=[];
        $singleroom = [];
        $ip = "192.168.10.10";
         $TBO = new TBO;
         $apiSettings = ApiSettings::where('status',1)->first();
         $data = array( "EndUserIp"=>  $ip,
                        "TokenId"  =>  $apiSettings->auth_key,
                        "ResultIndex"=> $request->ResultIndex,
                        "HotelCode"  => $request->HotelCode,
                        "TraceId"    => $request->TraceId);
        $rooms =  json_decode($TBO->hotelRooms(($data)));
        $roomindex = $rooms->GetHotelRoomResult->RoomCombinations->RoomCombination[$request->roomkey];
        //print_r((array)$roomindex->RoomIndex); 
        $matchindex = $rooms->GetHotelRoomResult->HotelRoomsDetails;
        //print_r($matchindex);
        foreach ($matchindex as $row){
            //print_r($row->RoomIndex);
            if (in_array($row->RoomIndex, ((array)$roomindex->RoomIndex)))
            {
                $singleroom[] = array('RoomIndex' => $row->RoomIndex,
                                      'RoomTypeCode' =>$row->RoomTypeCode,
                                      'RoomTypeName' =>$row->RoomTypeName,
                                      'RatePlanCode' =>$row->RatePlanCode,
                                      'BedTypeCode' => null,
                                      'SmokingPreference' =>0,
                                      'Supplements' => null,
                                      'Price'=> $row->Price);
            }
            else{
                //echo "0";
            }
            
        }
       //print_r($singleroom);
       // exit;
        //$singleroom =  $rooms->GetHotelRoomResult->HotelRoomsDetails[$request->roomkey];
        for($i=0; $i< count(explode(',',$request->NoOfAdults)); $i++){
            $a[] = $arr[0]=array('RoomIndex' => $singleroom[$i]['RoomIndex'],
                                'RoomTypeCode' =>$singleroom[$i]['RoomTypeCode'],
                                'RoomTypeName' =>$singleroom[$i]['RoomTypeName'],
                                'RatePlanCode' =>$singleroom[$i]['RatePlanCode'],
                                'BedTypeCode' => null,
                                'SmokingPreference' =>0,
                                'Supplements' => null,
                                'Price'=> $singleroom[$i]['Price']);
        
        
        //            );  
        //unset($detail['HotelRoomsDetails'][0]['Price']->GST);
                }
                //print_r($a); exit;
        $detail = array('HotelRoomsDetails'=> $a);
        //print_r(($detail));exit; 
        $rest = array('HotelName'=>$request->HotelName,
                      'GuestNationality' => 'IN',
                      'NoOfRooms' => count(explode(',',$request->NoOfAdults)),
                      'ClientReferenceNo' => 0,
                     'IsVoucherBooking' =>true,);  
        //print_r(json_encode(array_merge($detail,$data,$rest)));exit;
       
        return $TBO->hotelBlockRooms((array_merge($detail,$data,$rest)),['postData'=>$request->all()]);                      
    }

    /**
     * Submit Hotel Booking Detail
     * @method submitdetail
     * @param null
     */
    public function submitdetail(Request $request)
    { 
        $ip = "192.168.10.10";
        $TBO = new TBO;
        $apiSettings = ApiSettings::where('status',1)->first();
        for($i = 1 ; $i <=  count($request->Title);$i++){
            $passenger[] = array('Title'           => $request->Title[$i],
                               'FirstName'         => $request->FirstName[$i],
                               'LastName'          => $request->LastName[$i],
                               'Phoneno'           => $request->Phoneno,
                               'Email'             => $request->Email,
                               'PaxType'           => 1,
                               'LeadPassenger'     => true,
                               'Age'               => 0,
                               'PassportNo'        => "",
                               'PassportIssueDate' => '0001-01-01T00: 00: 00',
                               'PassportExpDate'   => '0001-01-01T00: 00: 00');
                              
         }
        $data = array( "EndUserIp"=>  $ip,
                       "TokenId"  =>  $apiSettings->auth_key,
                       "ResultIndex"=> Session::get('querystring')['ResultIndex'],
                       "HotelCode"  => Session::get('querystring')['HotelCode'],
                       "TraceId"    => Session::get('querystring')['TraceId']);
        $rooms =  json_decode($TBO->hotelRooms(($data))); 

        $singleroom =  $rooms->GetHotelRoomResult->HotelRoomsDetails[Session::get('querystring')['roomkey']];
            for($i=0; $i< count(explode(',',$request->NoOfAdults)); $i++){
                           $a[] = $arr[0]=array('RoomIndex' => $singleroom->RoomIndex,
                           'RoomTypeCode' =>$singleroom->RoomTypeCode,
                           'RoomTypeName' =>$singleroom->RoomTypeName,
                           'RatePlanCode' =>$singleroom->RatePlanCode,
                           'BedTypeCode' => null,
                           'SmokingPreference' =>0,
                           'Supplements' => null,
                           'Price'=> $singleroom->Price,
                           'HotelPassenger' =>$passenger);
            }
        $rest = array('HotelName'=>Session::get('querystring')['HotelName'],
                    'GuestNationality' => 'IN',
                    'NoOfRooms' => count(explode(',',Session::get('querystring')['NoOfAdults'])),
                    'ClientReferenceNo' => 0,
                'IsVoucherBooking' =>true,); 

        $data['HotelRoomsDetails'] = $a;
        $data = array_merge($data,$rest);
        //print_r($data['HotelRoomsDetails'][0]['Price']->OfferedPriceRoundedOff); exit;
        Session::put('total_amount',$data['HotelRoomsDetails'][0]['Price']->OfferedPriceRoundedOff);
        Session::put('user_email',$request->Email);
        Session::put('mobileNo',$request->Phoneno);
        Session::put('countryCode',Session::get('querystring')['countryid']);
        Session::put('tickets',serialize($passenger));
        return $data; 
        //return $TBO->bookRoom($data);
    }
}
