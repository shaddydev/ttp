@extends('admin::layouts.admin')
@section('admin::content')

       
<div class="content">
  <div class="container-fluid">
     <!--flash message-->
           <div class="response" ></div>
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
                                <h4 class="title">Enable LCC on</h4>
                                @foreach($fix_services as $data)
                                <div class="togglebutton">
                                    <label>
                                    @if($data->has_lcc==1)
                                        <input class="lcc-toggle" table="portal_fix_services" data-id="{{$data->id}}" value="{{$data->id}}" name="lcc-trigger" type="checkbox" checked="1">
                                    @else
                                        <input class="lcc-toggle" table="portal_fix_services" data-id="{{$data->id}}" value="{{$data->id}}"  name="lcc-trigger" type="checkbox">
                                    @endif
                                    <span class="toggle"></span>
                                     <span><i class="fa fa-{{$data->fa_class}}"></i></span>
                                     {{$data->display_title}}
                                     @if($data->service_key=='flight')
                                        <hint class="font-italic" >( You can manage LLC on each flight from <a href="{{url('admin/lcc/flights')}}" >here</a>)</hint>
                                     @endif
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

