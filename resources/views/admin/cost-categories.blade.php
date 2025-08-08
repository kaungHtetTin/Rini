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
            <h1 class="h3 mb-0 text-gray-800">Cost Category</h1>
        </div>
        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        <div class="card" style="padding:20px;">
            <div>
                <div class="h6">Add New Category</div>
                <form action="{{route('admin.cost-categories')}}" method="POST">
                    @csrf
                    <div style="display: flex">
                        <input style="flex: 1;margin-right:15px;" type="text" name="category" id="category" class="form-control">
                        <button class="btn btn-primary mb-3" type="submit" style="float:right">Add Now</button>
                    </div>
                    <p class="error">
                        {{$errors->first('category')}}
                    </p>
                </form>
            </div>
       
            <br>
            <h6>Category List</h6>
           
            <div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Category</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{$category->category}}</td>
                                <td width="80px">
                                    @if ($category->id > 2)
                                        <a class="action-button btn btn-primary"  href="#" data-toggle="modal" 
                                            data-target="#edit-modal-{{$category->id}}">
                                            Edit
                                        </a>
                                    @endif
                                </td>

                                <div class="modal fade" id="edit-modal-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="">Edit Category</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            
                                            <div class="modal-body">
                                               
                                                <form action="{{route('admin.cost-categories.modify',$category->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input class="form-control mb-3" type="text" name="category" value="{{$category->category}}" placeholder="Enter a category">
                                                    <button class="btn btn-primary" style="float: right">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                        
                </table>
            </div>
        </div>
    </div>
@endsection