@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
  <div class="container-fluid">
    <div class="page-title">
      <h3>All Transactions
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
          <span>All Transactions
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
          All Transactions
          </h4>
         <?php //print_r($user); exit;?>
          <div class="card-body">
            <div class="account-details">
              <!--profile form-->
              <div class="account-details">
                @include('agent::message')
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
                      $datefrom = app('request')->input('datefrom');
                      $dateto = app('request')->input('dateto');
                      $wallet = app('request')->input('wallet');
                      $tr_type = app('request')->input('tr_type');
                      $addfilter = app('request')->input('addfilter');
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
                      <div class="adding filters row mb-2">
                      
                        <form method="GET" class="form-inline" action="">

                            {{csrf_field()}}

                            <div class="form-group col-md-2">
                              <input type="text" name="datefrom" value="{{$datefrom}}" autocomplete="off" id = "datefrom" placeholder="Date From" data-style="select-with-transition" class="form-control datepicker" value="">
                            </div>

                            <div class="form-group col-md-2">
                              <input type="text" name="dateto" value="{{$dateto}}" autocomplete="off" id = "dateto" placeholder="Date To" data-style="select-with-transition" class="form-control amount" value="" >
                            </div>

                            <div class="form-group col-md-3">
                              <select class="selectpicker wallet" value="{{$wallet}}"  id="wallet" data-style="select-with-transition"  name="wallet" title="Select wallet">
                              <option value="">None</option>
                              <option value="1">Cash</option>
                              <option value="2">Credit</option>
                            </select>
                            </div>

                            <div class="form-group col-md-3">
                              <select class="selectpicker tr_type" value="{{$tr_type}}"  id="tr_type" data-style="select-with-transition"  name="tr_type" title="Select Transaction">
                              <option value="">None</option>
                              <option value="1">Credit</option>
                              <option value="2">Debit</option>
                            </select>
                            </div>
                            
                            <div class="form-group col-md-2">
                              <input type="submit" class="btn btn-primary " name="addfilter">
                            </div>
                        </form>
                  </div>
                   <?php $qstring = '?'.Request::getQueryString() ?? '';?>
                  <div class="col-md-12 mb-3">
                    <a href="{{url('agent/dashboard/exportExcel'.$qstring)}}" class="float-right badge badge-pill badge-warning" name="addfilter" >Download CSV</a>
                  </div>
                <div class="table-responsive">
                <table class="table table-bordered">
                      <thead class="text-nowrap">
                        <tr>
                       
                          <th class="text-center"> #</th>
                          <th class="text-right">Date - Time</th>
                          <th>Amount</th>
                          <th>Transaction Type</th>
                          <th>Wallet type	</th>
                          <th>Note</th>
                          <th>Reference</th>
                          <th>Balance</th>
                        </tr>
                       </thead>
                       <tbody>
                       @forelse($transaction as $detail)
                       <tr>
                       <td>{{$loop->iteration}}</td>
                       <td>{{ $detail->updated_at }}</td>
                       <td>{{$detail->amount}} </td>
                       <td>{{$detail->tr_type == 1 ? 'Credit' : 'Debit'}}</td>
                       <td>{{$detail->wallet_type == '1' ? 'Cash' : 'Credit'}}</td>
                       <td>{{$detail->note}}</td>
                       @if($detail->ref_id!==NULL)
                        <td><a href="{{url(Auth::user()->role->name.'/bookings/viewdetails/'.$detail->ref_id)}}">{{ App\WalletTransactions::get_reference_no_by_booking_id($detail->ref_id)}}</a></td>
                       @else 
                       <td>-</td>
                       @endif
                       <td>₹ {{$detail->balance}}</td>
                       @empty
                       </tr>
                       @endforelse
                     
                    </tbody>
                    </table>
                    {{ $transaction->appends(['datefrom' => $datefrom,'dateto' => $dateto, 'wallet' =>$wallet,'tr_type'=>$tr_type])->links() }}
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
