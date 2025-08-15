@extends('admin.master')
@section('content')
    <style>
        .my-card{
            padding:15px;
            margin-top: 30px;
        }

        .my-card img{
            width: 150px;
            height: 150px;
            border-radius: 150px;
            border:2px solid rgb(98, 98, 98);
            padding:2px;
            margin:auto;
        }
        .name{
            color:#333;
            text-align: center;
        }

        .edit-menu{
            text-align: center;
        }
        .edit-menu a{
            margin: 7px;
            border-radius: 50%;
            color: white;
            width: 40px;
            height: 40px;
        }

        .error{
            color:red;
            font-size: 12px;
        }

        .action-button{
            padding:3px;
            font-size: 12px;
            margin:3px;
        }
        table tr td{
            font-size: 14px;
        }
    </style>

    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Employee Detail</h1>
             
        </div>

        <div class="card my-card">
            <br>
            <img src="http://localhost/rini/storage/app/public/{{$employee->image_url}}" alt="" srcset="">
            <br>
            <div class="name">
                <h5>{{$employee->name}}</h5>
            </div>
            <div class="edit-menu">
                <a href="{{route('admin.employees.edit',$employee->id)}}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                </a>
                
                <a class="btn btn-success" href="#">
                    <i class="fas fa-phone-alt"></i>
                </a>

                <a class="btn btn-danger" href="#">
                    <i class="fas fa-trash"></i>
                </a>
                
            </div>
            <br><br>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <table class="table">
                        <tr>
                            <td> <i class="fab fa-openid"></i> ID </td>
                            <td> {{$employee->id}} </td>
                        </tr>
                        <tr>
                            <td> <i class="fas fa-phone-alt"></i> Phone </td>
                            <td> {{$employee->phone}} </td>
                        </tr>
                        <tr>
                            <td> <i class="fas fa-envelope"></i> Email </td>
                            <td> {{$employee->email}} </td>
                        </tr>
                    </table>
                </div>
                 
                <div class="col-lg-6 col-md-6">
                    <table class="table">
                        <tr>
                            <td> <i class="fas fa-id-card"></i> NRC ID </td>
                            <td> {{$employee->nrc_id}} </td>
                        </tr>
                        <tr>
                            <td> <i class="fab fa-bitcoin"></i> Salary Amount </td>
                            <td> {{$employee->salary}} </td>
                        </tr>
                        <tr>
                            <td> <i class="fas fa-city"></i> Address </td>
                            <td> {{$employee->address}} </td>
                        </tr>

                    </table>
                </div>
                 
            </div>
        </div>

        <div class="card my-card">
            @if (session('msg'))
                <div class="alert alert-success">
                    {{session('msg')}}
                </div>
            @endif
            <h5>Pay Now</h5>
            <br>
            <form action="{{route('admin.salary-records.add')}}" method="post">
                @csrf
                <div class="mb-3">
                    <span>Salary</span>
                    <input class="form-control" type="text" name="salary" id="" value="{{$employee->salary}}">
                    <p class="error">{{$errors->first('salary')}}</p>
                </div>

                <div class="mb-3">
                    <span>Bonus</span>
                    <input class="form-control" type="text" name="bonus" id="">
                    <p class="error">{{$errors->first('bonus')}}</p>
                </div>
                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                <button class="btn btn-primary" type="submit" style="float: right;">Pay Now</button>

            </form>
        </div>

        <div class="card my-card">
            @if (session('msgRecordDelete'))
                <div class="alert alert-success">
                    {{session('msgRecordDelete')}}
                </div>
            @endif
            <h4>Payment History</h4> <br>
             <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($salary_records as $record)
                            <tr>
                                <td>{{$record->created_at->diffForHumans()}}</td>
                                <td>{{$record->financial->amount}}</td>
                                <td>
                                    <a class="btn btn-danger action-button" href="#" data-toggle="modal" 
                                        data-target="#delete-modal-{{$record->id}}"> 
                                        <i class="fas fa-trash"></i> Delete 
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete-modal-{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Delete Record</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="alert alert-warning">
                                            Do you really want to delete this record?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.salary-records.destroy',$record->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="1" value="{{$record->id}}">
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-bar">
                    {{$salary_records->links()}}
                </div>
            </div>
        </div>

        

    </div>
@endsection