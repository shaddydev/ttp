@extends('admin::layouts.admin')
@section('admin::content')
<style>label.main-label {
   display: block;
   font-weight: 500;
   margin-bottom: 0px;
   font-size: 15px;
   border-radius: 4px;
   color: #050505;
   }
   label.main-label:before {
   content: '';
   width: 50px;
   height: 1px;
   position: absolute;
   bottom: -2px;
   /* background: #ccc; */
   }
</style>
<div class="content">
   <div class="container-fluid">
      <!--flash message-->
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
                     <i class="material-icons">account_box </i>
                  </div>
                  <h4 class="card-title">Add Permission</h4>
               </div>
               <div class="card-body">
                  <form method="post" class="form-horizontal" action="{{url('admin/assign/permission/'.Request::segment(4))}}">
                     {!! csrf_field() !!}
                     <div class="row">
                     <div class="col-sm-12">
                     <label class="main-label">Select Role</label>
                      <select class = "form-control" name = "role" onchange = "movetourl(this.value);" required>
                          <option value = "">Choose Role</option>
                                @forelse($roles as $role)
                                  <option value = "{{$role['id']}}" {{Request::segment(4) == $role['id'] ?'selected' : '' }}>{{$role['name']}}</option>
                                @empty
                                @endforelse
                        </select>
                      </div>
                      </div>
                     <div class="row">
                      <?php //echo "<pre>";print_r($added);exit;?>
                        <!-- fname-->
                        @forelse($menus as $menu)
                        <div class="col-sm-12">
                           <div class="maincontent">
                              <label class="main-label">{{$menu->name}}</label>
                              @if(count($menu->node)>0)
                             
                              <div class="custom-control custom-checkbox mb-3">
                             
                             <input type="checkbox" class="custom-control-input" id="{{$loop->iteration}}" name="privilege[]" value = "{{$menu->id}}" <?php if(in_array($menu->id,$added)) { echo "checked";};?>>
                             <label class="custom-control-label" for="{{$loop->iteration}}">{{$menu->name}}</label>
                           </div>
                              @endif
                              @if(count($menu->node)==0)
                              <div class="custom-control custom-checkbox mb-3">
                             
                             <input type="checkbox" class="custom-control-input" id="{{$loop->iteration}}" name="privilege[]" value = "{{$menu->id}}" <?php if(in_array($menu->id,$added)) { echo "checked";};?>>
                             <label class="custom-control-label" for="{{$loop->iteration}}">{{$menu->name}}</label>
                           </div>
                              @endif
                              <div class="row">
                              
                                 @foreach( $menu->node as $node)
                                 <div class="col-md-3">
                                    <div class="custom-control custom-checkbox mb-3">
                                       <input type="checkbox" class="custom-control-input" id="{{'node'.$node->id}}" name="privilege[]" value = "{{$node->id}}" <?php if(in_array($node->id,$added)) { echo "checked";};?>>
                                       <label class="custom-control-label" for="{{'node'.$node->id}}">{{$node->name}}</label>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                           <!-- <div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
                              <label>{{$menu->name}}</label>
                                <input type="checkbox" class="" name="privilege[]" value = "{{$menu->id}}" <?php //if(in_array($menu->id,$added)) { echo "checked";};?>>
                               </div> -->
                        </div>
                        @empty 
                        @endforelse
                     </div>
                     <input type="submit" class="btn btn-primary" name="adduser">
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection