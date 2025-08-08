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
        .error{
            color:red;
            font-size: 12px;
        }
    </style>
    <div class="container-fluid">
        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Outcome</h1>
        </div>

        <div>
             <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($financials as $financial)
                            <tr>
                                <td>{{$financial->created_at->diffForHumans()}}</td>
                                <td>{{$financial->financial_category->category}}</td>
                                <td>{{$financial->title}}</td>
                                <td>{{$financial->amount}}</td>
                                <td>
                                     <a class="btn btn-danger action-button" href="#" data-toggle="modal" 
                                        data-target="#delete-modal-{{$financial->id}}"> Delete </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete-modal-{{$financial->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                            <form action="{{route('admin.financials.destroy',$financial->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="status" value="1" value="1">
                                                <button class="btn btn-danger">Delete</button>
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
        <div>
            {{$financials->links()}}
        </div>

    </div>
@endsection