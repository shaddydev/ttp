@extends('layouts.app')

@section('content')

<section class="page-title-wrapper">
				<div class="container-fluid">
					<div class="page-title">
						<h3>Verify Email</h3>
						<ul>
							<li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
							<li><span>Verify Email</span></li>
						</ul>
					</div>
				</div>
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
