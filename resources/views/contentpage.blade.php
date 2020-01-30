	@extends('layouts.app')
	@section('title', $pageinfo['0']['page_title'])
	@section('content')


	<section class="page-title-wrapper">
		<div class="container-fluid">
			<div class="page-title">
				<h3>{{ ($pageinfo['0']['page_title']) }}</h3>
				<ul>
					<li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
					<li><span>{{ ($pageinfo['0']['page_name']) }}</span></li>
				</ul>
			</div>
		</div>
	</section>


	<section class="login-page-form">
		<div class="container">
			<div class="form-main">
				<div class="form-inner-register">
						{{ ($pageinfo['0']['page_description']) }}
				</div>
			</div>
		</div>

	</section>

	@endsection