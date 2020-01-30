@extends('layouts.app')
	@section('title', 'Bank Detail')
	@section('content')


	<section class="page-title-wrapper">
		<div class="container-fluid">
			<div class="page-title">
				<h3>Bank Detail</h3>
				<ul>
					<li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
					<li><span>Bank Detail</span></li>
				</ul>
			</div>
		</div>
	</section>


	<section class="login-page-form">
		<div class="container">
			<div class="form-main">
				<div class="form-inner-register">
						<?php echo $detail;?>
				</div>
			</div>
		</div>

	</section>

	@endsection