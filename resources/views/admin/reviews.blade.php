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
            <h1 class="h3 mb-0 text-gray-800">Reviews</h1>
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
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Review</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Review</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($reviews  as $review)
                            <tr>
                                <td> {{$review->customer->name}}</td>
                                <td>{{$review->customer->phone}}</td>
                                <td>{{$review->message}}</td>
                                <td>
                                    <a class="btn btn-danger action-button" href="#" data-toggle="modal" 
                                        data-target="#disable-modal-{{$review->id}}"> Delete </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="disable-modal-{{$review->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Delete Review</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="alert alert-warning">
                                            Do you really want to disable this review?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.reviews.destroy',$review->id)}}" method="POST">
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
                <div class="pagination-bar">
                    {{$reviews->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection