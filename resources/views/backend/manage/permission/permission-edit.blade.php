@extends('layout.master')
@section('title', 'Add New Permission')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"><b>Add New Permission</b></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{URL('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Add New Permission</li>
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
                    <div class="panel-heading">Add New Permission</div>
                    <div class="panel-body pan">
                   
                    <form role="form" action="{{ route('permissions.update',$permission->id ) }}" method="post" >

                    {{ csrf_field() }}  {{ method_field('PUT') }}

                           <div class="col-md-6">
                            <div class="form-group {{  $errors->has('display_name') ? 'has-error' : '' }}">
                                <label>Display Name<span style="color: red">*</span></label>
                            <input type="text"  class="form-control {{  $errors->has('display_name') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Display name" id="display-name" name="display_name" value="{{ $permission->display_name}}">

                                @if( $errors->has('display_name'))
                                <p class="invalid-feedback" style="color: red;">{{ $errors->first('display_name')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{  $errors->has('name') ? 'has-error' : '' }}">
                                <label>Name<span style="color: red">*</span></label>
                                <input type="text" class="form-control {{  $errors->has('name') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Name" id="name" name="name" value="{{ $permission->name}}" disabled>
                                @if( $errors->has('name'))
                                <p class="invalid-feedback" style="color: red;">{{ $errors->first('name')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                            <textarea class="form-control" cols="5" rows="5" name="description">{{ $permission->description }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="form-group">
                                <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Information</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
