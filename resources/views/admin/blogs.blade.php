@extends('admin.master')
@section('content')
    <style>
        .my-card{
            padding:5px;
            cursor: pointer;
            color:#333;
        }

        .my-card img{
            width: 100%;
            border-radius: 5px;
            display: inline;
        }

        .my-card .date{
            color:#777;
            font-size: 14px;
        }

        .my-card .short{
            color:#333;
            font-size: 14px;
        }

        .my-card .title{
            color:#333;
            font-size: 16px;
            font-weight: 500;
        }

        .edit-menu{
            text-align: right;
        }
        .edit-menu a{
            margin: 3px;
            color: white;
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
            <h1 class="h3 mb-0 text-gray-800">Blogs</h1>
            <a href="{{route('admin.blogs.add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Blog</a>
        </div>

        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card" style="margin-bottom: 5px;">
                        <a href="{{route('admin.blogs.show',$blog->id)}}" style="text-decoration: none">
                            <div class="my-card">
                                <img src="https://www.riniforyou.com/storage/app/public/{{$blog->image_url}}" alt=""> 
                                <div>
                                    <div class="title mt-3">{{$blog->title}}</div>
                                    <div class="short">{{$blog->short_description}}</div>
                                    <div class="date">{{$blog->created_at->diffforHumans()}} . Updated by {{$blog->admin()->name}}</div>
                                    <div class="edit-menu">
                                        <a href="{{route('admin.blogs.edit',$blog->id)}}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a class="btn btn-danger" href="#" data-toggle="modal" 
                                                    data-target="#disable-modal-{{$blog->id}}">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="modal fade" id="disable-modal-{{$blog->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="">Disable Product</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="alert alert-warning">
                                Do you really want to delete this blog.
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <form action="{{route('admin.blogs.destroy',$blog->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="status" value="1">
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection