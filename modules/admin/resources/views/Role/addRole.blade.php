@extends('admin::layouts.admin')
@section('admin::content')

       
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
              <i class="material-icons">accessibility </i>
            </div>
              @if($rolename == '')
             <h4 class="card-title">Add Role</h4>
             
             @else <h4 class="card-title">Edit Role</h4>
             <div class="pull pull-right"><a href="{{url('admin/role/create')}}" class="btn btn-fill btn-rose">Add Role</a></div>
             @endif
          </div>
          <div class="card-body">
            <form method="post" class="form-horizontal" action="">
            <?php //print_r($rolename);exit;?>
              {!! csrf_field() !!}
                <div class="row">
                   <!-- fname-->
                    <div class="col-sm-12">
                        <div class="row">
                          <label class="col-sm-2 col-form-label">Role Name</label>
                          <div class="col-sm-10">
                            <div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
                              <input type="text" class="form-control" name="role" required placeholder="Enter new Role" value = "{{@$rolename->name}}">
                              <span class="text-danger">{{ $errors->first('role') }}</span>
                            </div>
                          </div>
                        </div>
                    </div>
                    <!--last name-->
                    
                </div>
                <input type="submit" class="btn btn-primary" name="submit">
              </form>
           
          </div>
        </div>
      </div>
    </div>
     <!-- Fetch ROLES -->
   
            
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">accessibility </i>
            </div>
            <h4 class="card-title">Role List</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                   
                    <th class="text-right">Actions</th>
                  </tr>
                </thead>
                <tbody>
               
                @forelse ($roles as $role)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$role['name']}}</td>
                  <td class="text-right"><a href="{{url('admin/role/edit/'.$role['id'])}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                       <a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{url('admin/subadmin/delete/'.$role['id'])}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a></td>
                </tr> 
                @empty
               @endforelse
                </tbody>
              </table>
              </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

