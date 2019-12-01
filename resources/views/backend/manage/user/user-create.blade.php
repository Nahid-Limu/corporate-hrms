@extends('layout.master')
@section('title', 'Add New User')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->


    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"><b>Add New User</b></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{URL('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Add New User</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <style>
        .form-group{
            padding: 13px;
            padding-bottom: 0px;
        }
    </style>
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">Add New User</div>
                    <div class="panel-body pan">
                        {{--{{Form::open(['method'=>'POST','route'=>''])}}--}}

                    <form action="{{ route('users.store') }}" method="post">

                        {{ csrf_field() }}

                        <div class="row">
                             <div class="col-md-6">
                                <div class="form-group {{  $errors->has('name') ? 'has-error' : '' }}">
                                    <label>Name<span style="color: red">*</span></label>
                                <input type="text" class="form-control {{  $errors->has('name') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Name" id="name" name="name" value="{{ old('name')}}" required>
                                    @if( $errors->has('name'))
                                    <p class="invalid-feedback" style="color: red;">{{ $errors->first('name')}}</p>
                                    @endif
                                </div>
                            </div>  <div class="col-md-6">
                                <div class="form-group {{  $errors->has('status') ? 'has-error' : '' }}">
                                    <label for="display-name-bn">User Account Status</label>
                                    <select class="form-control" placeholder="Select Status" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div> 
                        </div>
                 
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group {{  $errors->has('email') ? 'has-error' : '' }}">
                                <label>Email<span style="color: red">*</span></label>
                                <input type="email"  class="form-control {{  $errors->has('email') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="email" id="display-name" name="email"  required>

                                @if( $errors->has('email'))
                                <p class="invalid-feedback" style="color: red;">{{ $errors->first('email')}}</p>
                                @endif
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group {{  $errors->has('role') ? 'has-error' : '' }}">
                                <label>Role<span style="color: red">*</span></label>
                                <select id="inputState" class="form-control" name="role" required> 
                                <option value="">Choose Role</option>
                                @foreach ($roles as $role)
                                <option value="{{  $role->id }}" {{ (old("roles") == $role->id ? "selected":"") }}>{{ $role->display_name }}</option>
                                @endforeach
                                {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
                            </select>
                            </div> 
                        </div> 
                    </div> 

                    
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group {{  $errors->has('password') ? 'has-error' : '' }}">
                               <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                @if ($errors->has('password'))
                                <span class="invalid-feedback"  style="color: red;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> 
                       <div class="col-md-6">
                            <div class="form-group {{  $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>    
                        

                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                  @foreach ($permissions as $permission)
                            <input type="checkbox" value="{{$permission->id}}" name="permis"  />Test<br />
                                @endforeach
                            </div>
                        </div>  --}}


                         {{-- <div class="col-md-12">
                            <div class="form-group">
                                  @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" value="{{ $permission->id }}" id="p-{{ $permission->id }}"  name="permissions[]">
                                    <label class="form-check-label" for="p-{{ $permission->id }}">{{ $permission->permissionsdisplay_name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div> --}}

                         
                        <div class="col-md-12">
                            <hr>
                            <div class="form-group">
                                <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Information</button>
                            </div>
                        </div>
                    </div> 
                    

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
