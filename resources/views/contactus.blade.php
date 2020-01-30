@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')
		<section class="page-title-wrapper">
				<div class="container-fluid">
					<div class="page-title">
						<h3>Contact Us</h3>
						<ul>
							<li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
							<li><span>Contact Us</span></li>
						</ul>
					</div>
				</div>
			</section>


			<section class="login-page-form">
				<div class="container">

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
										@if ($message = Session::get('warning'))
												<div class="alert alert-warning">
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

					<div class="form-main">
						<div class="form-inner-register">
							<form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
								 {!! csrf_field() !!}
								<div class="row">
									<div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
									<label>Name</label>
									<input type="text" class="form-control" name="name" placeholder="Enter your name">
									 <span class="text-danger">{{ $errors->first('name') }}</span>
								</div>
								
								<div class="col-md-6 form-group {{ $errors->has('emailid') ? 'has-error' : '' }}">
									<label>Email Id</label>
									<input type="text" class="form-control" name="emailid" placeholder="Enter Email Id">
									 <span class="text-danger">{{ $errors->first('emailid') }}</span>
								</div>
								<div class="col-md-2 form-group {{ $errors->has('countrycode') ? 'has-error' : '' }}">
									<label>Country Code</label>
									 <select class="form-control selectpicker" data-style="select-with-transition" name="countrycode" title="Select CountryCode">
		                                @if(count($mobile_countrycode)>0)              
		                                @foreach($mobile_countrycode as $mobcode)
		                                  <option value="{{ $mobcode->Countrycode }}">{{ $mobcode->Countrycode }}</option>
		                                @endforeach
		                                @endif
		                              </select>
									<span class="text-danger">{{ $errors->first('countrycode') }}</span>
								</div>
								<div class="col-md-4 form-group {{ $errors->has('mobilenumber') ? 'has-error' : '' }}">
									<label>Mobile number</label>
									<input type="text" class="form-control" name="mobilenumber" placeholder="Enter mobile number">
									<span class="text-danger">{{ $errors->first('mobilenumber') }}</span>
								</div>

								
								<div class="col-md-6 form-group {{ $errors->has('address') ? 'has-error' : '' }}">
									<label>Full Address</label>
									 <input id="autocomplete" class="form-control"  name="address"
                                         placeholder="Enter full address"
                                         onFocus="geolocate()"
                                         type="text" />
									<span class="text-danger">{{ $errors->first('address') }}</span>
								</div>
								
								
								<div class="col-md-12 form-group {{ $errors->has('message') ? 'has-error' : '' }}">
									<label>Your Message</label>
									<textarea class="form-control" rows="4" name="message" placeholder="Enter you message"></textarea>
									<span class="text-danger">{{ $errors->first('message') }}</span>
								</div>
								

								

							</div>
							<input type="submit" value="Submit Now" class="btn btn-primary" name="contactsubmit"></button>
								
							</form>

						</div>
					</div>
				</div>
				
			</section>

			@endsection