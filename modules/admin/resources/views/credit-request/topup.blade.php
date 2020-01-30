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
          
            <h4 class="card-title">Topup Credit/Cash</h4>
            <div class="pull pull-right"><a href="{{url('admin/credit-requests')}}" class="btn btn-fill btn-rose">Go Back</a></div>
          </div>
          <div class="card-body">
            <h2>{{$credit_requests['user']['user_details']['agentname'] != '' ? $credit_requests['user']['user_details']['agentname'] : $credit_requests->user->fname.' '.$credit_requests->user->lname }}</h2>
            <h5 class="text-primary" >Credit limit : &#x20b9;{{$credit_requests->user->user_details->credit }}</h5>
            <h5 class="text-success" >Cash Balance : &#x20b9;{{$credit_requests->user->user_details->cash }}</h5>
            <h5 class="text-info" >Pending Balance : &#x20b9;{{ (App\WalletTransactions::pending_balance($credit_requests->user->id))?App\WalletTransactions::pending_balance($credit_requests->user->id):NULL }}</h5>
            
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Amount</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" value="{{$credit_requests->amount}}" name="amount" required placeholder="Amount">
                             <span class="text-danger">{{ $errors->first('amount') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                 </div>

                 <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Wallet Type</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('wallet_type') ? 'has-error' : '' }}">
                                <select class="selectpicker" data-style="select-with-transition" required name="wallet_type" title="Select Wallet" >
                                    @if($credit_requests->wallet_type=='2')
                                        <option selected value="2">Credit</option>
                                        <option value="1">Cash</option>
                                    @else if($credit_requests->wallet_type=='1')
                                        <option  value="2">Credit</option>
                                        <option selected value="1">Cash</option>
                                    @endif
                                </select>
                             <span class="text-danger">{{ $errors->first('wallet_type') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                 </div>
              <input class="btn btn-primary" type="submit" value="Add to Wallet" name="create">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

