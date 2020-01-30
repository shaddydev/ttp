@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
  <div class="container-fluid">
    <div class="page-title">
      <h3>Request for Credit
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
            </button>Request for Credit
          </h4>
          <div class="card-body">
            <div class="account-details">
              <!--profile form-->
              <div class="account-details">
                @include('agent::message')
                <div class="edit-profile-form">
                <form class="form-horizontal" action="" method="POST"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="row form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                      <label class="col-md-3" >Amount *
                      </label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" value="{{old('amount')}}" placeholder="Amount" name="amount" >
                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                      </div>
                    </div>

                    <div class="row form-group{{ $errors->has('wallet_type') ? ' has-error' : '' }} ">
                      <label class="col-md-3" >Wallet *
                      </label>
                      <div class="col-md-9">
                         <select class="selectpicker form-control" value="{{old('wallet_type')}}" data-style="select-with-transition" name="wallet_type" title="Select Wallet">
                             <option value="2" >Credit</option>
                             <option value="1"  >Cash</option>
                          </select>
                          <span class="text-danger">{{ $errors->first('wallet_type') }}</span>
                      </div>
                    </div>

                    <div class="row form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
                      <label class="col-md-3" >Remarks *
                      </label>
                      <div class="col-md-9">
                        <textarea class="form-control" value="{{old('remarks')}}" placeholder="Remarks" name="remarks" ></textarea>
                        <span class="text-danger">{{ $errors->first('remarks') }}</span>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <button type="Submit" class="btn btn-primary form-submit" >Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- edit profile comp form-->
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
