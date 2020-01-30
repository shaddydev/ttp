@extends('layouts.app')
@section('content')
<section class="page-title-wrapper">
  <div class="container-fluid">
    <div class="page-title">
      <h3>Send Payment Confirmation
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
          <span>Payment Confirmation
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
            </button>
          </h4>
          <div class="card-body">
            <div class="account-details">
              <!--profile form-->
              <div class="account-details">
                
                @include('agent::message')
                <div class="edit-profile-form">
                <form class="form-horizontal" action="" method="POST" >
                    {{ csrf_field() }}
                    
                    <div class="row form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                      <label class="col-md-3" >Amount *
                      </label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" value="{{old('amount')}}" placeholder="Amount" name="amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                      </div>
                    </div>
                    <div class = "row form-group{{ $errors->has('payment_mode') ? ' has-error' : '' }}">
                      <label class="col-md-3" >Payment Mode *
                      </label>
                      <div class="col-md-9">
                        <select name = "payment_mode" class = "form-control">
                          <option>Credit Card</option>
                          <option>Debit Card</option>
                          <option>Net Banking</option>
                          <option>NEFT</option>
                          <option>TransferPay Through UPI</option>
                          <option>Other(Please specify in Remarks)</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('payment_mode') }}</span>
                      </div>
                    </div>
                    <div class = "row form-group{{ $errors->has('transaction_id') ? ' has-error' : '' }}">
                      <label class="col-md-3" >Transaction ID *
                      </label>
                      <div class="col-md-9">
                        <input type = "text" class= "form-control" name = "transaction_id" placeholder ="Enter Transaction ID" value = "{{old('transaction_id')}}" required>
                        <span class="text-danger">{{ $errors->first('transaction_id') }}</span>
                      </div>
                    </div>
                    <div class = "row form-group{{ $errors->has('transaction_date') ? ' has-error' : '' }}">
                      <label class="col-md-3" >Transaction date *
                      </label>
                      <div class="col-md-9">
                        <input type = "text" class= "form-control" name = "transaction_date" id = "dateto" {{old('transaction_date')}} placeholder = "Transaction date" required>
                        <span class="text-danger">{{ $errors->first('transaction_date') }}</span>
                      </div>
                    </div>
                    <div class="row form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
                      <label class="col-md-3" >Remarks *
                      </label>
                      <div class="col-md-9">
                        <textarea class="form-control" value="{{old('remarks')}}" placeholder="Remarks" name="remarks" required></textarea>
                        <span class="text-danger">{{ $errors->first('remarks') }}</span>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12 text-right">
                        <button type="Submit" name = "submit" class="btn btn-primary form-submit" onclick = "return confirm('Please make sure you have entered correct amount')">Submit</button>
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
