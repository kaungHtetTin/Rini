@extends('admin.master')
@section('content')
    <style>
        .action-button{
            padding:3px;
            font-size: 12px;
            margin:3px;
        }
        table tr td{
            font-size: 14px;
        }
        .access_level{
            margin: 3px;
            padding:3px;
            border-radius: 5px;
            display: inline;
            color: white;

        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admins</h1>
            <a href="{{route('admin.admins.add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Add New</a>
        </div>

        <div>
            @if (session('msg'))
                <div class="alert alert-success">
                    {{session('msg')}}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Access</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Access</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{$admin->id}}</td>
                                <td>{{$admin->name}}</td>
                                <td>{{$admin->email}}</td>
                                <td>
                                    @foreach ($admin->admins as $admin_access)  
                                        <span class="access_level card bg-success">
                                            {{$admin_access->access_level->title}}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-primary action-button" href="{{route('admin.admins.edit',$admin->id)}}">Edit</a>

                                    @if ($admin->disable == 0)
                                        <a class="btn btn-danger action-button" href="#" data-toggle="modal" 
                                        data-target="#disable-modal-{{$admin->id}}"> Disable </a>
                                    @else
                                        <a class="btn btn-success action-button" href="#" data-toggle="modal" 
                                        data-target="#enable-modal-{{$admin->id}}">Activate</a>
                                    @endif

                                </td>
                            </tr>

                            <div class="modal fade" id="disable-modal-{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Disable Admin</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="alert alert-warning">
                                            Do you really want to disable this admin?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.admins.manage-status',$admin->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="1" value="1">
                                                <button class="btn btn-danger">Disable</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="enable-modal-{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Activate Admin</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="alert alert-info">
                                            Do you really want to activate this admin?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.admins.manage-status',$admin->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="0" value="0">
                                                <button class="btn btn-success">Activate</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection