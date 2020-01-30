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
                   <i class="fa fa-money" aria-hidden="true"></i>
                  </div>
                  <h4 class="card-title">Credit Requests</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Code</th>
                          <th>Agency</th>
                          <th>Amount</th>
                          <th>Wallet type</th>
                          <th>Remarks</th>
                          <th>Status</th>
                          <th>Date/Time</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>

 

                      <tbody>
                        @if(count($credit_requests)>0)              
                        <?php $i = 1; ?>
                        @foreach($credit_requests as $tr)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td id="name_{{ $i }} "><a href="{{url('/admin/users/editusers/'.$tr->user->id)}}" target="_new" >{{ $tr->user->user_details->unique_code }}</a></td>                 
                            <td>{{ $tr->user->user_details->agentname }}</td> 
                            <td>{{ $tr->amount }}</td> 
                            <td>
                            @if($tr->wallet_type == '2')
                                <span class="badge badge-pill badge-warning">Credit</span>
                            @else
                               <span class="badge badge-pill badge-info">Cash</span>
                            @endif
                            </td>
                            <td>{{ $tr->remarks }}</td> 
                            <td>
                            @if($tr->is_paid == '1')
                                <span class="badge badge-pill badge-success">Paid</span>
                            @else
                               <span class="badge badge-pill badge-danger">Un-Paid</span>
                            @endif
                            </td>
                            <td>{{ $tr->created_at }}</td>
                            <td class="td-actions text-right">
                               
                                @if($tr->is_paid == '1')
                                <!--<a href="{{url('admin/credit-requests/update-status/'.$tr->id.'/0')}}" class="btn btn-success btn-link">mark as un-paid</a>-->
                                @else
                                <!--<a href="{{url('admin/credit-requests/update-status/'.$tr->id.'/1')}}" class="btn btn-danger btn-link">mark as paid</a>-->
                                @endif
                                @if($tr->is_paid == '0')
                                  <a href="{{url('admin/credit-requests/topup/'.$tr->user->id.'/'.$tr->id)}}" class="btn btn-success btn-link"><i class="fa fa-money" aria-hidden="true"></i> Topup</a><br>
                                  <a href="{{url('admin/credit-requests/update-status/'.$tr->id.'/2')}}" onclick = "return  confirm('Are you sure to cancel this request?')"class="btn btn-danger btn-link"><i class="fa fa-money" aria-hidden="true"></i> Cancel</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                    {{ $credit_requests->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection