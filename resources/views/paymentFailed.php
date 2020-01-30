@extends('layouts.app')

@section('content')

<section class="booking" >
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-8">
								<div class="confirm">
									<div class="confirmIcon"><i class="fas fa-check"></i></div>
									<div class="confirmDeail">
										<h3></h3>
										<p>Sorry! Your payment is <strong>Failed.</strong></p>
										<p>Reference Number - <strong>{{$bookingdetail[0]['booking_reference_id']}}</strong></p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="printBill">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="bookingMessage">
									<p>
										Your paymnet is <strong>declined</strong> due to some technical issues. Please try again.
									</p>
								</div>
							</div>
						</div>
					</div>
				</section>

@endsection