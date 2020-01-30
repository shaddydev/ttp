@extends('admin::layouts.admin')
@section('admin::content')
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                     <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Transaction List - {{$userinfo->agentname}}</h4>
               </div>
               <div class="card-body">
               <form>
               <div class="row">
                  <div class="col">
                     <input type="text" class="form-control" id="fromdate" placeholder="Date From" name="datefrom">
                  </div>
                  <div class="col">
                     <input type="text" class="form-control" id = "todate" placeholder="Date to" name="dateto">
                  </div>
                  <div class="col">
                     <button type="submit" class="btn btn-primary mb-2">Submit</button>
                  </div>
               </div>
               
               </form>
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">#</th>
                              <th>Amount</th>
                              <th>Transaction Type</th>
                              <th>Wallet type</th>
                              <th>Reference</th>
                              <th>Balance</th>
                              <th>Date & Time</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse($detail as $row)
                           <tr>
                             
                              <td>{{$loop->iteration}}</td>
                              <td>{{$row['amount']}}</td>
                              <td>@if(($row['ref_id'] != '') && ($row['wallet_type'] == 4) && ($row['tr_type'] == 1) &&($row['used_by'] == 1))  Refund - @endif {{$row['tr_type'] == 1 ? 'Credit' : 'Debit'}}</td>
                              <td><span class="badge badge-pill {{$row['wallet_type'] == 1 ? 'badge-info' : ($row['wallet_type'] == 2 ? 'badge-warning' : 'badge-success')}}">{{$row['wallet_type'] == 1 ? 'Cash' : ($row['wallet_type'] == 4 ? 'Advance' : 'Credit')}}</span></td>
                              <td>{{$row['ref_id']}}</td>
                              <td>{{$row['balance']}}</td>
                              <td>{{ $row['updated_at'] }}</td>
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