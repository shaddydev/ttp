@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
  <div class="container-fluid">
    <div class="page-title">
      <h3>Credit Request
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
          <span>Credit Request
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
          Credit Request
          <!-- <a href = "" class = "text-center">Paynow</a> -->
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
                     
                  
                <div class="table-responsive">
                <table class="table table-bordered">
                      <thead class="text-nowrap">
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-right">Name</th>
                          <th>Amount</th>
                          <th>Wallet type	</th>
                          <th>Note</th>
                          <th>Status</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                       </thead>
                       <tbody>
                       <?php //echo "<pre>"; print_r($creditRequest);?>
                       @forelse($creditRequest as $credit)
                       <tr>
                       <td>{{$loop->iteration}}</td>
                       <td>{{ $credit['user']->fname }} {{ $credit['user']->lname }}</td>
                       <td>{{ $credit->amount}}</td>
                       <td>{{ $credit->wallet_type == 2 ? 'Credit' : 'cash'}}</td>
                       <td>{{ $credit->remarks}}</td>
                       <td>{{ $credit->is_paid == 1 ? 'Paid' : ($credit->is_paid == 0 ? 'unpaid' :'Cancel')}}</td>
                       <td>{{ $credit->updated_at}}</td>
                       @if($credit->is_paid < 1 )
                       <td><a href = "javaScipt:void(0)" id="myBtn" class="" data-toggle="modal" data-target="#myModal{{$loop->iteration}}">Paynow</a> | <a href = "{{url('distributor/cancel/credit/request/'.$credit->id)}}" onclick="return confirm('Are you sure you want cancel ?');">Cancel</a>
                        @else <td></td>
                      @endif
                       <!-- Open model pop on click  -->
                        <!-- Modal -->
                                  <div class="modal fade" id="myModal{{$loop->iteration}}" role="dialog">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Topup Credit/Cash</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              </div>
                                              <form action = "" method = "get">
                                              <div class="modal-body">
                                                  <p>Your Credit Balance : {{Auth::user()->user_details->credit != '' ? Auth::user()->user_details->credit :0}}</p>
                                                  <p>Your Cash Balance : {{Auth::user()->user_details->cash != '' ? Auth::user()->user_details->cash :0}}</p>
                                               
                                                  <h4>{{ $credit['user']->fname }} {{ $credit['user']->lname }}</h4>
                                                  <p>Credit Balance : {{ $credit['user']['user_details']['credit'] != '' ? $credit['user']['user_details']['credit'] : 0 }}
                                                  <p>Cash Balance : {{ $credit['user']['user_details']['cash'] != '' ? $credit['user']['user_details']['cash'] : 0 }}</p>
                                                  <input type = "hidden" name = "userid" value = "{{$credit->user_id}}">
                                                  <input type = "hidden" name = "creditid" value = "{{$credit->id}}"
                                                  <label>Request Amount<input type = "text" name = "amount" class = "form-control" value = "{{ $credit->amount}}"></label>
                                                  <label>Wallet type
                                                    <select class =  "form-control" name = "wallet_type">
                                                      <option value = "1" {{ $credit->wallet_type == 1 ? 'selected' : ''}}>Cash</option>
                                                      <option value = "2" {{ $credit->wallet_type == 2 ? 'selected' : ''}}>Credit</option>
                                                    </select>
                                                  </label>
                                                  
                                               
                                              </div>
                                              
                                              <div class="modal-footer">
                                                  <input type="submit" name = "create" class="btn btn-primary" value = "Add">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              </div>
                                              </form>
                                             
                                          </div>
                                      </div>
                                  </div>
                       <!-- end Model popup -->
                       </td>
                       </tr>
                       @empty
                       @endforelse
                      
                    </tbody>
                    </table>
                    {{ $creditRequest->links() }}
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
