@extends('admin::layouts.admin')
@section('admin::content')

       
<div class="content">
  <div class="container-fluid">
     <!--flash message-->
           <div class="response" ></div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b>{{ $message }} </b></span>
                </div>
            @endif
            <!--end flash messages-->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">settings</i>
            </div>
            <h4 class="card-title">Settings</h4>
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
              {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="title">Enable API</h4>
                                @foreach($api as $data)
                                <div class="togglebutton">
                                    <label>
                                    @if($data->status==1)
                                        <input class="api-toggle" value="{{$data->id}}" name="api-trigger" type="checkbox" checked="1">
                                    @else
                                        <input class="api-toggle" value="{{$data->id}}"  name="api-trigger" type="checkbox">
                                    @endif
                                    <span class="toggle"></span>
                                    {{$data->name}}
                                    </label>
                                </div>
                                @endforeach
                                
                                </div>
                        
                            </div>
                
                       </div>
                    </div>
               </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

