<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Travel Trip Plus</title>
      <!-- <link href="https://fonts.googleapis.com/css?family=roboto:300,300i,400,400i,500,500i,600,700,800,900" rel="stylesheet"> -->
   </head>
   <?php //echo "<pre>"; print_r($postdata)?>
   <body style="background-color: #f1f1f1; font-family: roboto, sans-serif; font-size: 15px; margin: 0; padding: 0;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background: #f1f1f1; font-family: 'roboto', sans-serif; font-size: 14px;">
         <tr>
            <td align="center">
               <table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
                  <tr>
                     <td align="center">
                        <table border="0" cellpadding="10" cellspacing="0" style="width:100%">
                           <tr>
                              <td align="center"><a href=""><img src="https://www.traveltripplus.com/public/uploads/siteinfo/resizepath/26339476829fb2cb816b6b29395c7b2b.png"></a></td>
                           </tr>
                        </table>
                        <table border="0" cellpadding="10" cellspacing="0" style="width:100%; background: #fff; border:3px solid #ddd;">
                            <tr><td style="text-align:center; font-size:20px; color:#ff0000;">Cancellation Request</td></tr>
                            <tr>
                              <td>
                                 <table border="1" cellpadding="10" cellspacing="0" style="width:100%;">
                                    <tr>
                                       <td><strong>Agency:</strong></td>
                                       <td>{{$canceldetail['users_bookings']['user_details']['agentname']}}</td>
                                    </tr>
                                    <tr>
                                       <td valign="top"><strong>Number Of Passenger(S):</strong></td>
                                       <td valign="top">
                                          @foreach($canceldetail['bookingdetail'] as $detail)
                                             <p style="margin-top:0;">{{$loop->iteration}}. {{$detail['fname']. ' '. $detail['lname']}}</p>
                                          @endforeach
                                       </td>
                                    </tr>
                                    <tr>
                                       <td><strong>PNR Number:</strong></td>
                                       <td>{{$canceldetail['pnr']}}</td>
                                    </tr>
                                    <tr>
                                       <td><strong>Refund Type:</strong></td>
                                       <td>{{$postdata['refundtypename']}}</td>
                                    </tr>
                                    <tr>
                                       <td><strong>Request Date:</strong></td>
                                       <td>{{date('d M y')}}</td>
                                    </tr>
                                    <tr>
                                       <td><strong>Remark:</strong></td>
                                       <td>{{$postdata['notes']}}</td>
                                    </tr>
                                 </table>
                              </td>
                            </tr>
                            
                            <tr><td align="right">Team,<br/><a href="">TravelTripPlus</a></td></tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>