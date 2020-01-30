@extends('admin::layouts.admin')
@section('admin::content')

<div class="content">
  <div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">account_box</i>
            </div>
          <h4 class="card-title">Account Detail</h4>      
        </div>                
      <div class="card-body">
      <form method = "post">
      {{csrf_field()}}
      <textarea  class = "form-control" id="ckeditor" name = "bankdetail">{{$admin->bankdetail}}</textarea>
      <input type = "submit" class = "btn btn-primary">
      </form>
      </div>
      </div>
      </div>
  </div>
</div>

@endsection
