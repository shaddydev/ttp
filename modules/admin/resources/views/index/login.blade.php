@extends('admin::layouts.login')
@section('admin::content')

<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('../public/admin/img/login.jpg'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" role="form" method="POST" action="{{ url('admin/auth') }}" >
            {{ csrf_field() }}
                @if(Session::has('failed'))
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="alert alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>Oh snap!</strong> {{ session("failed") }}
                        </div>
                    </div>
                </div>
                @endif
              <div class="card card-login">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Login</h4>
                </div>
                <div class="card-body ">
                  <span class="bmd-form-group">
                  <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="Email...">
                      @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
					            @endif
                    </div>
                  </span>
                  <span class="bmd-form-group">
                  <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" class="form-control" name="password" required id="password" placeholder="Password...">
                      @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                      @endif
                    </div>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                      Forgot Your Password?
                    </a>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
            <footer class="footer">
                <div class="container">
                <div class="copyright float-right">
                                &copy;
                                <script>
                                document.write(new Date().getFullYear())
                                </script>, made with <i class="material-icons">favorite</i> by
                                <a href="#" target="_blank">PIIPL</a> for a better web.
                </div>
                </div>
            </footer>
            </div>
        </div>

@endsection

