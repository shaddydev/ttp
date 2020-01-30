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
            @if ($message = Session::get('warning'))
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>
                      <b>{{ $message }} </b></span>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
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
                    <i class="material-icons">account_box</i>
                  </div>
                  <h4 class="card-title">Textual Pages</h4>
                  <div class="pull pull-right"><a href="{{url('admin/sitetextualpages/add')}}" class="btn btn-fill btn-rose">Add Textual Page</a></div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Page Name</th>
                          <th>Page Title</th>
                          <th>Seo Title</th>
                          <th>Seo Keyword</th>
                          <th>Slug</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>


                      <tbody>
                      @if(count($textualpages)>0)              
                        <?php $i = 1; ?>
                        @foreach($textualpages as $textualpage)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $textualpage->page_name }}</td>                 
                            <td>{{ $textualpage->page_title }}</td>  
                            <td>{{ $textualpage->seo_title }}</td>
                            <td>{{ $textualpage->seo_keyword }}</td> 
                            <td>{{ $textualpage->slug }}</td> 
                            <td class="td-actions text-right">
                            <button type="button" rel="tooltip" class="btn btn-info btn-link" data-original-title="" title="">
                              <i class="material-icons">person</i>
                            </button>
                            @if($textualpage->status == '1')
                              <a href="{{url('admin/sitetextualpages/updatestatus/'.$textualpage->id.'/'.$textualpage->status)}}" class="btn btn-success btn-link"><i class="fa fa-circle green"></i></a>
                            @else
                              <a href="{{url('admin/sitetextualpages/updatestatus/'.$textualpage->id.'/'.$textualpage->status)}}" class="btn btn-danger btn-link"><i class="fa fa-circle red"></i></a>
                            @endif
                            <a href="{{url('admin/sitetextualpages/edittextualpage/'.$textualpage->id)}}" class="btn btn-success btn-link"><i class="fa fa-pencil"></i></a>
                           <!--  <button type="button" rel="tooltip" class="" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                            </button> -->
                            <a  onclick="return confirm('Are you sure you want to delete this item?');"  href="{{url('admin/sitetextualpages/deletetextualpage/'.$textualpage->id)}}" class="btn btn-danger btn-link"><i class="fa fa-trash"></i></a>
                           <!--  <button type="button" rel="tooltip" class="btn btn-danger btn-link" data-original-title="" title="">
                              <i class="material-icons">close</i>
                            </button> -->
                          </td>
                        </tr>
                        @endforeach
                      @endif
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