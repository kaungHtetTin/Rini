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
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Employees</h1>
            <a href="{{route('admin.employees.add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i>Add New</a>
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
                            <th>Departement</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#ID</th>
                            <th>Departement</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->department->department}}</td>
                                <td>{{$employee->name}}</td>
                                <td>{{$employee->phone}}</td>
                                <td>
                                    @if ($employee->disable == 0)
                                        <strong class="text-success">Active</strong>
                                    @else
                                        <span class="text-secondary">Out</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary action-button" href="{{route('admin.employees.show',$employee->id)}}"> View </a>
                                    <a class="btn btn-primary action-button" href="{{route('admin.employees.edit',$employee->id)}}">Edit</a>

                                    @if ($employee->disable == 0)
                                        <a class="btn btn-danger action-button" href="#" data-toggle="modal" 
                                        data-target="#disable-modal-{{$employee->id}}"> Out </a>
                                    @else
                                        <a class="btn btn-success action-button" href="#" data-toggle="modal" 
                                        data-target="#enable-modal-{{$employee->id}}">Reasign</a>
                                    @endif

                                </td>
                            </tr>

                            <div class="modal fade" id="disable-modal-{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Disable Employee</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="alert alert-warning">
                                            Do you really want to disable this employee?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.employees.manage-status',$employee->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="1" value="1">
                                                <button class="btn btn-danger">Disable</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="enable-modal-{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Reasign Employee</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="alert alert-info">
                                            Do you really want to reasign this employee?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.employees.manage-status',$employee->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="0" value="0">
                                                <button class="btn btn-success">Reasign</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach



                    </tbody>
                </table>
                <div class="pagination-bar">
                    {{$employees->links()}}
                </div>
                
            </div>
        </div>

    </div>
@endsection