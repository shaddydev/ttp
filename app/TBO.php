<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TBO extends Model
{
    public $API_TOKEN;

    public function authenticate($ip){
        $data = array(
            "ClientId"=> config('app.API_TBO_CLIENTID'),
            "UserName"=> config('app.API_TBO_USERNAME'),
            "Password"=> config('app.API_TBO_PASSWORD'),
            "EndUserIp"=> $ip
        );
        $url = config('app.TBO_AUTH_URL').'/rest/Authenticate';
        $resp = $this->ApiCall($data,$url);
        return $resp;
    }
    public function ApiCall($data,$url){
        // Prepare new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // Set HTTP Header for POST request 
        $headers = array('Content-Type: application/json');
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);
        return $result;
    }

    public function searchData($query){
        $url = config('app.TBO_FLIGHT_BASIC_URL').'/rest/Search/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function getCalenderFare($query){
        $url = config('app.TBO_FLIGHT_BASIC_URL').'/rest/GetCalendarFare/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function getFareRule($query){
        $url = config('app.TBO_FLIGHT_BASIC_URL').'/rest/FareRule/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function getPriceData($query){
        $url = config('app.TBO_FLIGHT_BASIC_URL').'/rest/PriceRBD/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function getFareQuote($query){
        $url = config('app.TBO_FLIGHT_BASIC_URL').'/rest/FareQuote/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function getSSR($query){
        $url = config('app.TBO_FLIGHT_BASIC_URL').'/rest/SSR/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function booking($query){
        $url = config('app.TBO_FLIGHT_BOOKING_URL').'/rest/Book/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function doTicket($query){
        $url = config('app.TBO_FLIGHT_BOOKING_URL').'/rest/Ticket/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    public function fareQuote($query)
    {
        $url = config('app.TBO_FLIGHT_BOOKING_URL').'/rest/FareRule/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }
    // Search Hotel
    public function searchHotel($query){
       //print_r($query);exit;
        $url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelResult/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    // Hotel Detail
    public function hotelDetail($query){
        $url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelInfo/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    // Hotel Room Detail
    public function hotelRooms($query)
    {
        $url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/GetHotelRoom/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    // Hotel block Room
    public function hotelBlockRooms($query)
    {
        $url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/BlockRoom/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }

    // book room

    public function bookRoom($query)
    {
        $url = 'http://api.tektravels.com/BookingEngineService_Hotel/hotelservice.svc/rest/Book/';
        $resp = $this->ApiCall($query,$url);
        return $resp;
    }
}

?>