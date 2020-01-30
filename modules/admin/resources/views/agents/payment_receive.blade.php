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
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                     <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Payment Received</h4>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">#</th>
                              <th>Agency</th>
                              <th>Credit Amount</th>
                              <th>Payment Mode</th>
                              <th>Status</th>
                              <th>Transaction  ID</th>
                              <th>Agent/Distributor</th>
                              <th class="text-right">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse($paymentusers as $detail)
                           <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$detail['paymentuserdetail']['agentname']}}</td>
                              <td>{{$detail['amount']}}</td>
                              <td>{{$detail['payment_mode']}}</td>
                              <td>{{$detail['is_paid'] == 0 ? 'Pending' : ($detail['is_paid'] == 1 ? 'Received' : 'Cancelled' )}}</td>
                              <td>{{$detail['transaction_id']}}</td>
                              <td>{{$detail['transaction_date']}}</td>
                              <td>
                                 @if($detail['is_paid'] == 0)<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{$loop->iteration}}" >Payment Receive</button>@endif
                                 <!-- start model popup -->
                                 <div class="modal fade" id="exampleModal{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">Please confirm Payment</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <form method = "post" action = "{{url('admin/verify-payment')}}">
                                             {{ csrf_field() }}
                                             <div class="modal-body">
                                                <?php //echo "<pre>"; print_r($user->paymentMade);exit; ?>
                                                <div class="row">
                                                   <div class="col-md-4">Amount</div>
                                                   <div class="col-md-7">
                                                      <h5 class="modal-title">{{ $detail['amount'] }}</h5>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-4">payment Mode</div>
                                                   <div class="col-md-7">
                                                      <h5 class="modal-title">{{ $detail['payment_mode'] }}</h5>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-4">Transaction ID</div>
                                                   <div class="col-md-7">
                                                      <h5 class="modal-title">{{ $detail['transaction_id'] }}</h5>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-4">Transaction Date</div>
                                                   <div class="col-md-7">
                                                      <h5 class="modal-title">{{ $detail['transaction_date'] }}</h5>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-4">Remark</div>
                                                   <div class="col-md-7">
                                                      <h5 class="modal-title">{{ $detail['remarks']}}</h5>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <input type = "hidden" name = "pid" value = "{{$detail['id']}}">
                                                </div>
                                             </div>
                                             <div class="modal-footer">
                                                <button type="submit" name = "submit" value = "cancel" class="btn btn-danger">Cancel</button> &nbsp;
                                                <button type="submit" name = "submit" value = "confirm" class="btn btn-primary">Confirm</button>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- end model popup -->
                              </td>
                           </tr>
                           @empty
                           @endforelse
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection