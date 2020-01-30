@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
  <div class="container-fluid">
    <div class="page-title">
      <h3>My Agents
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
          <span>Your Profile
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
            </button>My Agents
            <a href = "{{url('/distributor/create-agent')}}" class = "btn btn-primary float-right">Add New</a>
          </h4>
         <?php //print_r($user); exit;?>
          <div class="card-body">
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
                        <th scope="col">Status</th>
                        <th scope="col">Wallet(credit)</th>
                        <th scope="col">Wallet(cash)</th>
                        <th scope="col">Pending</th>
                        <th scope="col">Date (Created)</th>
                        <th>Modify</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->children as $agent)
                            <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$agent->fname}} {{$agent->lname}}</td>
                            <td>{{$agent->email}}</td>
                            <td>{{$agent->status == 1 ? 'Active' :'Inactive'}}</td>
                            <td>{{$agent->user_details['credit']}}</td>
                            <td>{{$agent->user_details['cash']}}</td>
                            <td> {{ (App\WalletTransactions::pending_balance($agent->id))?App\WalletTransactions::pending_balance($agent->id):NULL }}</td>
                            <td>{{$agent->created_at}}</td>
                            <td><a href = "{{url('distributor/edit-agent-detail/'.$agent->id)}}">Edit</a> | <a href = "{{url('distributor/delete-agent-detail/'.$agent->id)}}" onclick = "return confirm('Do you want to delete ?')">Delete</a>|<a href = "{{url('agent/booking')}}">View Booking</a></td>
                            </tr>
                        @endforeach
                     </tbody>
                    </table>
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
