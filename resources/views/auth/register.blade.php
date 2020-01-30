@extends('layouts.app')

@section('content')

        <section class="page-title-wrapper">
            <div class="container-fluid">
                <div class="page-title">
                    <h3>Register</h3>
                    <ul>
                        <li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
                        <li><span>Register</span></li>
                    </ul>
                </div>
            </div>
        </section>

         <section class="login-page-form">
            <div class="container-fluid">
               <div class="form-main">
                <div class="form-inner-register">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3  form-group{{ $errors->has('fname') ? ' has-error' : '' }}">
                                <label for="fname" class="control-label">First Name</label>

                                <div class="form-group">
                                    <input id="fname" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3  form-group{{ $errors->has('lname') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Last Name</label>

                                <div class="form-group">
                                    <input id="lname" type="text" class="form-control" name="lname" value="{{ old('lname') }}" required autofocus>

                                    @if ($errors->has('lname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6  form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="role" type="hidden"  name="role" value="1">

                                <div class="form-group">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6  form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Password</label>

                                <div class="form-group">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6  form-group">
                                <label for="password-confirm" class="control-label">Confirm Password</label>
                                <div class="form-group">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="col-md-6  form-group">
                                <div class="col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                        <ul class="inline-list">
								    <li>Already Register? <a href="{{ route('login') }}">Login</a></li>
						</ul>
                    </form>
                  </div>
               </div>
            </div>
         </section>
@endsection