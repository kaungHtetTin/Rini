@extends('admin.master')
@section('content')
    <style>
        label{
            font-size: 14px;
        }
        button{
            font-size: 14px;
        }

        .action-button{
            padding:3px;
            font-size: 12px;
            margin:3px;
        }
        table tr td{
            font-size: 14px;
        }
        .error{
            color:red;
            font-size: 12px;
        }

    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Department</h1>
        </div>
        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        <div class="card" style="padding:20px;">
            <div>
                <div class="h6">Add New Department</div>
                <form action="{{route('admin.departments')}}" method="POST">
                    @csrf
                    <div style="display: flex">
                        <input style="flex: 1;margin-right:15px;" type="text" name="department" id="department" class="form-control">
                        <button class="btn btn-primary mb-3" type="submit" style="float:right">Add Now</button>
                    </div>
                    <p class="error">
                        {{$errors->first('department')}}
                    </p>
                </form>
            </div>
       
            <br>
            <h6>Department List</h6>
            
            <div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Department</th>
                        <th>Employee</th>
                        <th width="80px">Action</th>
                    </thead>
                    <tbody>
                        @if (count($departments)>0)
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{$department->department}}</td>
                                    <td>{{$department->employees->count()}}</td>
                                    <td width="80px">
                                        <a class="action-button btn btn-primary"  href="#" data-toggle="modal" 
                                            data-target="#edit-modal-{{$department->id}}">
                                            Edit
                                        </a>
                                    </td>

                                    <div class="modal fade" id="edit-modal-{{$department->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="">Edit Department</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                
                                                    <form action="{{route('admin.departments.modify',$department->id)}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input class="form-control mb-3" type="text" name="department" value="{{$department->department}}" placeholder="Enter a department">
                                                        <button class="btn btn-primary" style="float: right">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="text-center"> No department</td>
                            </tr>
                        @endif
                    </tbody>
                        
                </table>
            </div>
        </div>
    </div>
@endsection