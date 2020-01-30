@extends('admin::layouts.admin')
@section('admin::content')

<div class="content">
        <div class="container-fluid">
          <!--flash message-->
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                    <b>{{ $message }} </b></span>
                </div>
            @endif

            <!--end flash messages--> 

            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b>{{ $message }} </b></span>
                </div>
            @endif
            <!--end flash messages-->
          <?php 
          $bookingid = app('request')->input('bookingid');
          $usersnames = app('request')->input('usersnames');
          $fromdate = app('request')->input('fromdate');
          $todate = app('request')->input('todate');
          $status = app('request')->input('status');
          $pnr = app('request')->input('pnr');
          ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">Bookings</i>
                  </div>
                  <h4 class="card-title">Booking</h4>
                  
                </div><br><br>
             <div class="card-body">
                   <div class="adding filters">
                    <form method="get" class="form-inline" action="">
                         <div class="form-group ">
                            <input type="text" name="bookingid" value="{{$bookingid}}" placeholder="By Reference ID" data-style="select-with-transition" class="form-control bookingid " value="" >
                         </div>
                         <div class="form-group ">
                          <input type="text" name="usersnames" placeholder="By Agent Code" value="{{$usersnames}}" data-style="select-with-transition" class="form-control bookingid " value="" >
                        </div>
                        <div class="form-group ">
                          <input autocomplete="off" value="{{$pnr}}"  name="pnr" class="form-control " id="pnr" placeholder="PNR" >
                        </div>
                        
                        <div class="form-group ">
                          <input autocomplete="off" value="{{$fromdate}}"  name="fromdate" class="form-control " id="fromdate" placeholder="Date from" >
                        </div>
                      
                        <div class="form-group ">
                          <input autocomplete="off" value="{{$todate}}"  name="todate" class="form-control " id="todate" placeholder="Date to" >
                        </div>

                        <div class="form-group ">
                          <select class="selectpicker status" value="{{$status}}"  id="status" data-style="select-with-transition"  name="status" title="Select Status">
                            <option value="">None</option>
                            <option value="0">confirmed</option>
                            <option value="1">Not-confirmed</option>
                            <option value="2">Cancelled</option>
                          </select>
                       </div>
                       
                       <div class="form-group ">
                        <input type="submit" class="btn btn-sm btn-primary " name="addfilter">
                         </div> 
                      </div>
                    </form>
                  </div>
              <br><br>
               
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="text-nowrap">
                        <tr>
                          <th class="text-center">#</th>
                          <th>Reference ID</th>
                          <th>Booking ID</th>
                          <th>Agency</th>
                          <th>PNR</th>
                          <th>Discount</th>
                          <th>Offered Price</th>
                          <th>Grand Total</th>
                          <th>Status</th>
                          <th>Created At</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($bookingslist as $booking)
                        <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                        {{$booking->booking_reference_id}} 
                        </td>
                        <td>{{$booking->BookingId}}</td>
                        <td>{{$booking->users_bookings->user_details->unique_code}}</td>
                         
                        <td>{{$booking->pnr}}</td>
                        <td>{{$booking->discount}}</td>
                        <td>₹ {{$booking->total}}</td>
                        <td>₹ {{$booking->total_display}}</td>

                        <td>
                            @if($booking->assignee_id != '0')
                              <a class="badge  badge-pill badge-warning text-white">Picked By @if($booking->assignee_id == '')<?php echo "";?> @else<?php echo getassigneename($booking->assignee_id); ?> @endif</a>
                              <br>
                            @endif
                            @if($booking->status == 0 )
                              <span class="badge badge-pill badge-secondary">Cancelled</span>
                            @elseif($booking->pnr == '')
                              <span class="badge badge-pill badge-danger">Not Confirmed</span>
                            @else
                             <span class="badge badge-pill badge-success">Confirmed</span>
                            @endif
                            @if($booking->is_request_change == 1)<span class="badge badge-pill badge-info">Change Request</span> @endif
                        </td>

                        <td>{{$booking->created_at}}</td>

                        <td class="text-right">
                            @if($booking->assignee_id == '0'  && $booking->status != 0 )
                              <a href="{{url('admin/booking/updateassignee/'.$booking->id)}}" class="badge badge-success">
                              pick</a>
                            @endif
                              
                            @if($booking->assignee_id == Auth::user()->id)
                              <a href = "{{url('admin/booking/editdetail/'.$booking->id)}}"  class="badge badge-info" >update</a>
                            @endif

                            <a href="{{url('admin/booking/viewdetails/'.$booking->id)}}" class="badge badge-info">details</a>

                            @if($booking->pnr==null && $booking->status != 0 )
                              <a href="{{url('admin/booking/cancel/'.$booking->id)}}" class="badge badge-danger" onclick="return confirm('Are you sure you want to cancel this?');">cancel</i></a>
                            @endif

                           </div>
                         </td>

                          <!-- updatepnrno -->
                          <div class="modal fade" id="updatepnrno{{$booking->id}}" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Update Booking PNR No.</h4>
                                </div>
                                <div class="modal-body">
                                  <form method="get" name="pnrupdateform">
                                    <div class="form-group row">
                                      <div class="col-md-12">
                                        <input type="text" name="pnrno" class="form-control">
                                        <input type="hidden" name="bookingid" value="{{$booking->id}}">
                                      </div>
                                      <input type="submit" class="form-control" name="updatepnrno">
                                    </div>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  
                                </div>
                              </div>
                            </div>
                         </tr>
                        @empty
                      @endforelse
                    </tbody>
                    </table>
                    {{ $bookingslist->appends(['bookingid' => $bookingid, 'usersnames' => $usersnames,'fromdate' => $fromdate,'todate' => $todate, 'status' =>$status])->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
