@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
  <div class="container-fluid">
    <div class="page-title">
      <h3>All Bookings
      </h3>
      <ul>
        <li>
          <a href="/">Home
          </a> 
          <span class="arrow-icon">
            <i class="fas fa-long-arrow-alt-right">
            </i>
          </span>
        </li>
        <li>
          <span>All Bookings
          </span>
        </li>
      </ul>
    </div>
  </div>
</section>
<section class="user-panel">
  <div class="container-fluid">
    <!-- Bootstrap row -->
    <div class="row" id="body-row">
        <!--sidebar-->
        <div class="col-md-3">
          @include('agent::layouts.sidebar')
        </div>
        <!--content-->
      <div class="col-md-9">
        <div class="card">
          <h4 class="card-header">
            My Bookings
          </h4>
         <?php //print_r($user); exit;?>
          <div class="card-body">
            <div class="account-details">
              <!--profile form-->
              <div class="account-details">
                
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
                         <?php
                               
                              ?>

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
                      $referenceid = app('request')->input('referenceid');
                      $pnr = app('request')->input('pnr');
                      $datefrom = app('request')->input('datefrom');
                      $dateto = app('request')->input('dateto');
                      $status = app('request')->input('status');
                      ?>
                 <div class="adding filters row mb-2">
                 <form method="GET" class="form-inline" action="">

                      {{csrf_field()}}

                      <div class="form-group col-md-2">
                        <input type="text" name="referenceid" value="{{$referenceid}}" autocomplete="off" id = "referenceid" placeholder="Reference ID" data-style="select-with-transition" class="form-control" value="" >
                      </div>

                      <div class="form-group col-md-2">
                        <input type="text" name="pnr" value="{{$pnr}}" autocomplete="off" id = "pnr" placeholder="PNR" data-style="select-with-transition" class="form-control" value="" >
                      </div>

                      <div class="form-group col-md-2">
                        <input type="text" name="datefrom" value="{{$datefrom}}" autocomplete="off" id = "datefrom" placeholder="Date From" data-style="select-with-transition" class="form-control datepicker" value="">
                      </div>

                      <div class="form-group col-md-2">
                        <input type="text" name="dateto" value="{{$dateto}}" autocomplete="off" id = "dateto" placeholder="Date To" data-style="select-with-transition" class="form-control amount" value="" >
                      </div>

                      <div class="form-group col-md-3">
                        <select class="selectpicker status" value="{{$status}}"  id="status" data-style="select-with-transition"  name="status" title="Select Status">
                        <option value="">None</option>
                        <option value="1">Confirmed</option>
                        <option value="0">Not Confirmed</option>
                      </select>
                      </div>


                      <div class="form-group col-md-2">
                        <input type="submit" class="btn btn-primary " name="addfilter">
                      </div>
                      </form>

                  </div>
                <div class="table-responsive">
                <table class="table table-bordered">
                      <thead class="text-nowrap">
                        <tr>
                          <th class="text-center">#</th>
                          <th>Reference ID</th>
                          <th>PNR</th>
                          <th>Net payable</th>
                          <th>Total</th>
                          <th>Confirmed Status</th>
                          <th>Created At</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                     <tbody>
                    
                      @forelse($bookingslist as $booking)
                     
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><a href="{{url(Auth::user()->role->name.'/bookings/viewdetails/'.$booking->id.'/'.$booking->user_id)}}" style = "color:blue">{{$booking->booking_reference_id}}</a></td>
                        <td><a href="{{url(Auth::user()->role->name.'/bookings/viewdetails/'.$booking->id.'/'.$booking->user_id)}}" style = "color:blue" >{{$booking->pnr}}</a></td>
                        <td>₹ {{$booking->total}}</td>
                        <td>₹ {{$booking->total_display}}</td>
                        <td> @if($booking->status == 0 )
                              <span class="badge badge-pill badge-secondary">Cancelled</span>
                            @elseif($booking->pnr == '')
                              <span class="badge badge-pill badge-danger">Not Confirmed</span>
                            @else
                             <span class="badge badge-pill badge-success">Confirmed</span>
                            @endif
                        </td>
                        <td>{{$booking->created_at}}</td>

                        <td align="right">
                          <div class="d-flex">
                          <a title="View Details" href="{{url(Auth::user()->role->name.'/bookings/viewdetails/'.$booking->id.'/'.$booking->user_id)}}" class="btn-link"><i class="fas fa-info-circle"></i></a> |
                           
                           @if($booking->pnr == '') 
                            @else
                            <a title="Change Request" href="{{url(Auth::user()->role->name.'/bookings/requestchange/'.$booking->id)}}" class="btn-link"><i class="far fa-arrow-alt-circle-up"></i></a>
                            @endif
                            @if($booking->is_request_change == 1) | <span class="badge badge-pill badge-success">Request send</span> @endif
                          </div>
                        </td>
                    
                            <!-- updatepnrno -->
                            <div class="modal fade" id="requestchange{{$booking->id}}" role="dialog">
                                <div class="modal-dialog">
                                
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Change Request (PNR: {{$booking->pnr}})</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form method="get" name="requestchange">
                                        <div class="form-group">
                                            <select class="selectpicker pickingstatus col-sm-2" id="pickingstatus" data-style="select-with-transition"  name="pickingstatus" title="Select Status" >
                                              <option value="-1">None</option>
                                              <option value="1">Not Picked</option>
                                              <option value="0">Picked</option>
                                               
                                            </select>
                                        </div>

                                        <div class="form-group ">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <label>Please select Refund Sectors</label>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <select class="selectpicker pickingstatus col-sm-2" id="pickingstatus" data-style="select-with-transition"  name="pickingstatus" title="Select Status" >
                                                <option value="-1">None</option>
                                                <option value="1">Not Picked</option>
                                                <option value="0">Picked</option>
                                                 
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                            
                                        <div class="form-group ">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <label>Please select Passengers</label>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <select class="selectpicker pickingstatus col-sm-2" id="pickingstatus" data-style="select-with-transition"  name="pickingstatus" title="Select Status" >
                                                <option value="-1">None</option>
                                                <option value="1">Not Picked</option>
                                                <option value="0">Picked</option>
                                                 
                                              </select>
                                            </div>
                                          </div>
                                        </div>



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
                            </div>

                      </tr>
                      @empty
                      @endforelse
                    </tbody>
                    </table>
                    {{ $bookingslist->appends(['bookingid' => $referenceid,'datefrom' => $datefrom,'dateto' => $dateto,'status'=>$status])->links() }}
                   </div>
                  </div>
               </div>

           
            </div>
          </div>
        </div>
      </div>
      <!-- end content-->
    </div>
  </div>
</section>
</div>
@endsection
