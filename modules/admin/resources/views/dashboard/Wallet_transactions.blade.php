@extends('admin::layouts.admin')
@section('admin::content')
<style>

#suggestion-box {margin-top:-1px;position: absolute; left:0; right:auto; min-width:160px; width:100%;}
#country-list{list-style:none;margin:0;padding:0;}
#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid; cursor: pointer;}
#country-list li:hover{background:#ece3d2;}

</style>
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
                  <h4 class="card-title">Wallet Transactions</h4>      
                </div>                
                <div class="card-body">
                
                <form method = "get" action = "">
                <h4 class="card-title">Filter Data</h4>
                  <div class = "row">
                      <div class="col-md-2">
                        <input type = "text" name = "unique_code" id = "unique_code" class = "form-control" Placeholder = "Unique code" value = "{{ app('request')->input('unique_code') }}" autocomplete="off">
                      </div>   
                      <div class="col-md-3">
                        <input type = "text" name = "agency" id="search-box" class = "form-control" Placeholder = "Agency Name" value = "{{ app('request')->input('agency') }}" autocomplete="off">
                        <div id="suggesstion-box"></div>
                      </div> 
                      <div class="col-md-3">
                        <input type = "text" name = "referenceid"  class = "form-control" Placeholder = "Refrence Id" value = "{{ app('request')->input('referenceid') }}" autocomplete="off">
                      </div> 
                       <div class="col-md-2">
                        <input type = "text" name = "datefrom" id = "walletfilterdatefrom" class = "form-control" Placeholder = "Choose start date" value = "{{ app('request')->input('datefrom') }}" autocomplete="off">
                      </div>
                      <div class="col-md-2">
                        <input type = "text" name = "dateto" id = "walletfilterdateto" class = "form-control" Placeholder = "Choose end date" value = "{{ app('request')->input('dateto') }}" autocomplete="off">
                      </div>      
                                    
                  </div>
                  <div class = "col-md-12 text-right">
                  <input type="submit" class="btn btn-primary">
                  </div>
                  </form>
                  <div class="walletTable table-responsive">
                    <table class="table table-bordered">
                      <thead style="white-space:nowrap;">
                        <tr>
                          <th class="text-center">#</th>
                          <th>Code</th>
                          <th>Agency</th>
                          <th>Amount</th>
                          <th>Transaction Type</th>
                          <th>Refrence Id</th>
                          <th>Wallet type</th>
                          <!-- <th>Note</th> -->
                          <th class="text-right">Date/Time</th>
                          <th>action</th>
                        </tr>
                      </thead>
                     <?php //print_r($transactions);?>

                      <tbody>
                        @if(count($transactions)>0)              
                        <?php $i = 1;?>
                            
                        @foreach($transactions as $tr)
                        <?php if($tr->booking_info != '' ){$decode = json_decode($tr->booking_info); } else{$decode = '';}?>
                      
                        <tr {{$tr->billed_status == 0 ? 'style = background:cdcdcd' : 'style = background:#d4edda'}}>
                            <td>{{ $i++ }}</td>
                            <td id="name_{{ $i }} "><a href="{{url('/admin/users/editusers/'.$tr->user->id)}}" target="_new" >{{ $tr->user->user_details->unique_code }}</a></td>                 
                            <td><?php echo  $tr->user->user_details->agentname != '' ?  $tr->user->user_details->agentname : $tr->user->fname ?></td> 
                            <td>{{ $tr->amount }}</td> 
                            <td>
                            @if($tr->tr_type == '1')
                                <span class="badge badge-pill badge-success">Credit</span>
                            @else
                               <span class="badge badge-pill badge-danger">Debit</span>
                            @endif
                            </td>
                            <td>@if($tr->ref_id != '' && $tr->tr_type == 2) {{ App\WalletTransactions::get_reference_no_by_booking_id($tr->ref_id)}}@endif</td>
                           
                            <td>
                            @if($tr->wallet_type == '1')
                                <span class="badge badge-pill badge-info">Cash</span>
                            @else
                               <span class="badge badge-pill badge-warning">Credit</span>
                            @endif
                            </td>
                            <!-- <td> <?php //if($decode != ''){echo 'flight Name '.$decode[0][0]->Airline->AirlineName , ' With PNR '. $tr->pnr .' from ' .$decode[0][0]->Origin->Airport->AirportCode. "  -  ".$decode[0][0]->Destination->Airport->AirportCode."  ( ".substr($decode[0][0]->Origin->DepTime,0,strpos($decode[0][0]->Origin->DepTime,'T'))." ) "; }else{ echo $tr->note;}?></td> -->
                            <td class="text-right" >{{ $tr->updated_at }}</td>
                             
                            <td >@if($tr->ref_id != '' && $tr->tr_type == 2)<a href = "{{url('admin/invoice/'.$tr->ref_id)}}" target = "_blank">@if(App\WalletTransactions::get_reference_no_by_booking_id($tr->ref_id)){{'Invoice'}}@endif</a>|@endif 
                            @if($tr->billed_status == 0)<a href = "{{url('admin/update-billed-status/'.$tr->id)}}">Unbilled</a> @else {{'Billed'}} @endif</td>
                            
                        </tr>
                        
                        @endforeach
                        @endif
                    </tbody>
                    </table>
                    <?php //echo $transactions->render(); ?>
                   
                    {{ $transactions->appends(request()->query())->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- sTART MODEL POPUP -->


<div class="modal" id="detailModal">
<div class="modal-dialog">
  <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Transaction Detail</h4>
     
    </div>
  
    <!-- Modal body -->
    <div class="modal-body" id = "responsedata">
        
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal" id = "dismiss">Close</button>
    </div>

  </div>
</div>
</div>
<!-- END MODEL POPUP -->
@endsection