@extends('layout.master')
@section('title', 'Edit User')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"><b>Edit User</b></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{URL('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Edit User</li>
        </ol>
        <div class="clearfix"></div>
    </div>

     @if (Session::has('message'))
          <div class="alert alert-success mt-3" role="alert">
              {!! Session::get('message') !!}
          </div>
        @endif
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

                    <form role="form" action="{{ route('users.update',$user->id ) }}" method="post" >

                    {{ csrf_field() }}  {{ method_field('PUT') }}


                        <div class="row">
                                <div class="col-md-6">
                                <div class="form-group {{  $errors->has('name') ? 'has-error' : '' }}">
                                    <label>Name<span style="color: red">*</span></label>
                                <input type="text" class="form-control {{  $errors->has('name') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Name" id="name" name="name" value="{{ $user->name }}" required>
                                    @if( $errors->has('name'))
                                    <p class="invalid-feedback" style="color: red;">{{ $errors->first('name')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{  $errors->has('status') ? 'has-error' : '' }}">
                                    <label for="display-name-bn">User Account Status</label>
                                    <select class="form-control" placeholder="Select Status" name="status">
                                      
                                        <option value="1" {{ $user->status === 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $user->status === 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group {{  $errors->has('email') ? 'has-error' : '' }}">
                                <label>Email<span style="color: red">*</span></label>
                            <input type="email"  class="form-control {{  $errors->has('email') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Email" id="email" name="email" value="{{ $user->email }}" required>

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
                                {{-- <option value="{{  $role->id }}">{{ $role->display_name }}</option>  --}}

                            
                                    @if (!empty($user->roles[0]))
                                  
                                    <option {{ $user->roles[0]->id === $role->id ? 'selected' : '' }} value="{{  $role->id }}">{{ ucwords($role->display_name) }}</option>
                                    @else
                                    <option value="{{  $role->id }}">{{ $role->display_name }}</option> 
                                        
                                    @endif
                                @endforeach
                            </select>
                            </div>
                         
                        </div> 
                    </div> 
                    
                    <div class="row">

                       <div class="col-md-6">
                            <div class="form-group {{  $errors->has('password') ? 'has-error' : '' }}">
                               <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback"  style="color: red;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> 
                       {{-- <div class="col-md-6">
                            <div class="form-group {{  $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>   --}}

                  
                   
                        
                        <div class="col-md-12">
                            <hr>
                            <div class="form-group">
                                <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Information</button>
                            </div>
                        </div>
                    </div>

                        </form>
                        {{--{{Form::close()}}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


