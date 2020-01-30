@extends('layouts.app')

@section('content')

         <section class="page-title-wrapper">
            <div class="container-fluid">
               <div class="page-title">
                  <h3>Reset Password</h3>
                  <ul>
                     <li><a href="/">Home</a> <span class="arrow-icon"><i class="fas fa-long-arrow-alt-right"></i></span></li>
                     <li><span>Reset Password</span></li>
                  </ul>
               </div>
            </div>
         </section>


         <section class="login-page-form">
            <div class="container-fluid">
               <div class="form-main">
                  <div class="form-inner">

                  @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>

                  </div>
               </div>
            </div>
         </section>
@endsection
