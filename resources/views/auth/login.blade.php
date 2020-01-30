@extends('layouts.app')

@section('content')
         <section class="page-title-wrapper">
				<div class="container-fluid">
					<div class="page-title">
						<h3>Login</h3>
						<ul>
							<li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
							<li><span>Login</span></li>
						</ul>
					</div>
				</div>
			</section>

         <section class="login-page-form">
            <div class="container-fluid">
               <div class="form-main">
                  <div class="form-inner">
                  <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           <label>Email</label>
                           <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                           <label>Password</label>
                           <input id="password" type="password" class="form-control" name="password" >

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                        <ul class="inline-list">
                           <li>New User? <a href="{{ route('register') }}">Create Account</a></li>
                           <li>
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                           </li>
                        </ul>
                     </form>
                  </div>
               </div>
            </div>
         </section>
@endsection
