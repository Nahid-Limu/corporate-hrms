@extends('layout.master')
@section('title', 'Role List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Role List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{URL('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Role List</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Role List
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="{{route('roles.create')}}" class="add-new-modal btn btn-success btn-square btn-sm"> <i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="doctor" class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Order</th>
                                <th>Display Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                     <tr>
                                     <td>{{ $role->id }}</td>
                                     <td>{{ $role->display_name }}</td>
                                    <td>
                                        <a  href="{{ route('roles.edit', $role->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                        {{-- <a href="" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a> --}}
                                    </td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $(document).ready(function() {
            $('#doctor').DataTable();
        });
    </script>
@endsection