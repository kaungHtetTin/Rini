@extends('admin.master')
@section('content')
    <style>
        .error{
            color:red;
            font-size: 12px;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add New Admin</h1>
        </div>

        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        <div class="card" style="padding:20px;">
            <form action="{{route('admin.admins.store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <span>Name</span>
                    <input class="form-control" type="text" name="name" id="" value="">
                    <p class="error">{{$errors->first('name')}}</p>
                </div>

                <div class="mb-3">
                    <span>Email</span>
                    <input class="form-control" type="text" name="email" id="" value="">
                    <p class="error">{{$errors->first('email')}}</p>
                </div>

                <div class="mb-3">
                    <span>Password</span>
                    <input class="form-control" type="text" name="password" id="" value="">
                    <p class="error">{{$errors->first('password')}}</p>
                </div>

                
                 <div class="mb-3">
                    <span>Access Control</span>
                    @foreach ($access_levels as $access)
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="access_{{$access->id}}" name="access_{{$access->id}}">
                                <label class="custom-control-label" for="access_{{$access->id}}">{{$access->title}}</label>
                            </div>
                        </div>
                    @endforeach
                    @if (session('access_error'))
                        <p class="my-error"> {{session('access_error')}}</p>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>


            </form>
        </div>

    </div>
@endsection