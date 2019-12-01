@extends('layout.master')
@section('title', 'User List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">User List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{URL('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">User List</li>
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
                            {{-- @if ($haserole) --}}
                            <div class="col-md-6">
                                User List
                            </div>
                            {{-- @endif --}}

                             @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                            <div class="col-md-6" style="text-align: right;">
                                <a href="{{route('users.create')}}" class="add-new-modal btn btn-success btn-square btn-sm"> <i class="fa fa-plus"></i> Add New</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="doctor" class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Order</th>
                                <th>Display Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                     <tr>
                                     <td>{{ $user->id }}</td>
                                     <td>{{ $user->name }}</td>
                                     <td>{{ $user->email }}</td>
                                  
                                     <td>
                                           @if($user->roles->count() > 0) 
                                        {{ $user->roles[0]->display_name }} 
                                          @else
                                          App User
                                     @endif
                                    </td>
                                  
                                       
                                   
                                     @if ($user->status==1)
                                         <td style="color: green;">Active</td>
                                     @else
                                         <td style="color: red;">Inactive</td>
                                     @endif
                                     
                                    <td>
                                        <a  href="{{ route('users.edit',$user->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                                        
                                        {{-- <form role="form" action="{{ route('users.destroy',$user->id ) }}" method="post" >
                                              {{ method_field('PUT') }}
                                            <input type="Submit" name="Submit" value="delete" class="btn btn-warning btn-xs">
                                        </form> --}}
                                       
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