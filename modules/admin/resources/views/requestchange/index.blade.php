@forelse($bookingsrequest as $key => $bookingrequest)
  <?php echo "<pre>";print_r(json_decode($bookingrequest['booking']['all_details'])); ?>
@empty
@endforelse

<?php die(); ?>
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
                  <h4 class="card-title">Agent/distributor</h4>
                  <div class="pull pull-right"><a href="{{url('admin/agents/add')}}" class="btn btn-fill btn-rose">Add New</a></div>
                  </div>
              
                 
                
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Booking Id</th>
                          <th>User</th>
                          <th>Refund Type</th>
                          <th>Refund Sector</th>
                          <th>Passengers</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                         @forelse($bookingsrequest as $bookingreq)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$bookingreq['booking']->BookingId}}</td>
                            <td>{{$bookingreq['bookingrequser']->fname}} &nbsp; {{$bookingreq['bookingrequser']->lname}}</td>
                            <td>
                              @if($bookingreq->refund_type == '')
                              @elseif($bookingreq->refund_type == '1')
                                Full Refund
                              @elseif($bookingreq->refund_type == '2')
                                Change ltinerary / reissue
                              @elseif($bookingreq->refund_type == '3')
                                Partial Refund
                              @elseif($bookingreq->refund_type == '4')
                                Flight Cancellation
                              @else
                              @endif
                            </td>
                            <td>
                              
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                          </tr>
                         @empty
                         @endforelse
                      </tbody>
                    </table>
                     {{ $bookingsrequest->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
