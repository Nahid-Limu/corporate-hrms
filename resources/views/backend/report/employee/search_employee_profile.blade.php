@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Search Employee</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Search Employee</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Search Employee</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
            <div class="row">
                    <div class="col-lg-8 col-md-8 col-md-offset-2">
                        <div class="panel panel-blue">
                            <div class="panel-heading ex-panel">
                                <div class="row">
                                    <div class="col-md-12">
                                        Search Employee
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="panel-body">        
                                <div class="col-md-12">
                                {!! Form::open(['method'=>'get','url'=>'search/employee/profile']) !!}

                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                    <div class="form-group">
                                        <label>Select Employee</label>
                                        <select class="form-control" id="employee" name="id" required>
                                        <option value="">Select</option>
                                        @foreach( $employee as  $employees)     
                                        <option value="{{$employees->id}}">{{$employees->name}} {{$employees->employeeId}}</option>
                                        @endforeach  
                                        </select>   
                                    </div>
                                        
                                    @else
                                         <div class="form-group">
                                        <label>Select Employee</label>
                                        <select class="form-control" id="employee" name="id" required>
                                        <option value="">Select</option>
                                        @foreach( $employee as  $employees)     
                                        <option value="{{$employees->id}}">{{$employees->name}} {{$employees->employeeId}}</option>
                                        @endforeach  
                                        </select>   
                                    </div>
                                    @endif
                                    <button type="submit" class="btn btn-success">
                                    <i class="fa fa-search"></i> View Profile</button>
                                {!! Form::close() !!}
                                </div>
                          </div>  
                      </div>
                </div>
          </div>   
    </div>
@endsection
@section('extra_js')
<script>
  $("#employee").select2();
</script>   
@endsection

