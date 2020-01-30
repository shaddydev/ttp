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
                  </button> Transaction Histroy
                  
               </h4>
               <div class="card-body">
                 <?php //print_r($walletHistory); exit;?>
                  <div class="account-details">
                     <!--profile form-->
                     <div class="account-details">
                        @include('agent::message')
                        <div class="edit-profile-form">
                        <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Wallet type</th>
                        <th scope="col">Transaction Type</th>
                        <th scope="col">Date (Created)</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                    
                       @foreach($walletHistory as $history)
                      
                       <tr>
                       <td>{{$loop->iteration}}</td>
                       <td>{{$history->user['fname'] . $history->user['lname'] }}</td>
                       <td>{{$history->user['email'] }}</td>
                       <td>{{$history['amount'] }}</td>
                       <td>{{$history['wallet_type'] == 2 ? 'Credit' : 'Cash'}}</td>
                       <td>{{$history['tr_type'] == 1 ? 'Credit' : 'Debit'}}</td>
                       <td>{{$history['updated_at']}}</td>
                       </tr>
                       @endforeach
                     </tbody>
                    </table>
                    {{$walletHistory->links()}}
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