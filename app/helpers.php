<?php
//site info
if (! function_exists('getsiteinfo')) {
function getsiteinfo() {
$data = \DB::table('site_info')
->select('*')
->get();
$newdata = collect($data);
return $newdata->toArray();
}
}




//site textualpages
if (! function_exists('gettextualpages')) {
function gettextualpages() {
$datatextual = \DB::table('textual_pages')
->select('*')
->get();
$newtextualdata = collect($datatextual);
return $newtextualdata->toArray();
}
}



//site textualpages
if (! function_exists('getaboutusfooter')) {
function getaboutusfooter() {
$dataaboutfooter = \DB::table('welcomedata')
->select('*')
->get();
$newdataaboutfooter = collect($dataaboutfooter);
return $newdataaboutfooter->toArray();
}
}

/**Fetch Side bar according to role id  */
if (! function_exists('getsidebar')) {
  function getsidebar($role_id = null) {
    if($role_id>4){
    $menus = DB::table('sidebar')->JOIN('sidebar_permission','sidebar_permission.sidebar_id','sidebar.id')
    ->where('role_id',$role_id)->orderBy('sort_order', 'asc')->get()->toArray();
          return $menus;
  } else{
    $menus = DB::table('sidebar')->orderBy('sort_order', 'asc')->get()->toArray();
  
  return $menus;
  }
}
  }



  //getassigneename
if (! function_exists('getassigneename')) {
    function getassigneename($assigneeid = null) {
      $namearray = \DB::table('users')->select('fname', 'lname')->where('id', $assigneeid)->get()->toArray();
      $name = $namearray[0]->fname." ".$namearray[0]->lname;
      return $name;
  }
}

 if (! function_exists('getticket')) { 
  function getticket($bookingid = null) {
    $ticket = DB::table('tickets')->where('booking_detail_id',$bookingid)->get(); 
    return $ticket[0]->ticket_number; 
  }
  } 
?>