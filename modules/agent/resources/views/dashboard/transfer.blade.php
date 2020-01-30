@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
   <div class="container-fluid">
      <div class="page-title">
         <h3>Transaction
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
               <span>Transaction
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
         @include('agent::layouts.sidebar')
         <!--content-->
         <div class="col">
            <div class="card">
               <h4 class="card-header">
                  <button class="panel-button">
                  <i class="fas fa-bars">
                  </i>
                  </button>Manage Transaction
                  <a href = "{{url('/distributor/wallet-transaction-histroy')}}" class = "btn btn-primary float-right">Transaction History</a>
               </h4>
               <div class="card-body">
                  <div class="account-details">
                     <!--profile form-->
                     <div class="account-details">
                        @include('agent::message')
                        <div class="edit-profile-form">
                           <form action = "" method  = "post">
                              {{csrf_field()}}
                              <div class = "row">
                                 <div class = "col-md-3">
                                    <div class="form-group">
                                       <label for="uname">Your Account:</label>
                                        <select class = "form-control" name = "from_acccount" required>
                                          <option value= "">Account Type</option>
                                          <option value = "{{$userdetail->credit.',credit'}}">Credit: {{$userdetail->credit}}</option>
                                          <option value = "{{$userdetail->cash .',cash'}}">Cash: {{$userdetail->cash}}</option>
                                        </select>
                                       <span class="text-danger">{{ $errors->first('fname') }}</span>
                                    </div>
                                 </div>
                                 <div class = "col-md-3">
                                    <div class="form-group">
                                       <label for="pwd">Agent Name:</label>
                                       <select class = "form-control" name = "user_name" >
                                          @forelse($userlist as $user)
                                          <option value = "{{$user->id}}">{{$user->fname}}</option>
                                          @empty
                                          @endforelse
                                        </select>
                                       <span class="text-danger">{{ $errors->first('lname') }}</span>
                                    </div>
                                 </div>
                                 <div class = "col-md-3">
                                    <div class="form-group">
                                       <label for="pwd">Agent Account Type:</label>
                                       <select class = "form-control" name = "account_type" >
                                          <option value = "cash">Cash</option>
                                          <option value = "credit">Credit</option>
                                        </select>
                                       <span class="text-danger">{{ $errors->first('lname') }}</span>
                                    </div>
                                 </div>
                                 <div class = "col-md-3">
                                    <div class="form-group">
                                       <label for="pwd">Amount:</label>
                                       <input type = "number" name = "amount" class = "form-control" placeholder = "Enter Transfer Amount" required>
                                       <span class="text-danger">{{ $errors->first('lname') }}</span>
                                    </div>
                                 </div>
                              </div>
                              <input type="submit" class="btn btn-primary" value = "submit" name = "submit">
                           </form>
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