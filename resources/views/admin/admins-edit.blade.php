@php
    $admin_access_levels = $admin->admins;
    function checkAccess($admin_access_levels, $access){
        $result = false;
        foreach ($admin_access_levels as $key=>$level) {
            if($level->access_level_id == $access->id){
                $result = true;
            }
        }
        return $result;
    }
@endphp
@extends('admin.master')
@section('content')
    <style>
        .error{
            color:red;
            font-size: 12px;
        }
        .info{
            padding:30px;
            text-align: center;
        }
        .info .name{
            font-size: 20px;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Admin</h1>
        </div>

        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        <div class="card" style="padding:20px;">

            <div class="info">
                <span><i class="fas fa-shield-alt"></i></span>
                <div class="name"> {{$admin->name}} </div>
                <div class="email"> {{$admin->email}} </div>
            </div>

            <form action="{{route('admin.admins.modify',$admin->id)}}" method="post">
                @method('PUT')
                @csrf

                <div class="mb-3">
                    <span>Name</span>
                    <input class="form-control" type="text" name="name" id="" value="{{$admin->name}}">
                    <p class="error">{{$errors->first('name')}}</p>
                </div>

                <div class="mb-3">
                    <span>Change Password</span>
                    <input class="form-control" type="text" name="password" id="" value="" placeholder="Enter password">
                    <p class="error">{{$errors->first('password')}}</p>
                </div>

                <div class="mb-3">
                    <span>Access Control</span>
                    @foreach ($access_levels as $access)
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="access_{{$access->id}}" name="access_{{$access->id}}" @php
                                    if(checkAccess($admin_access_levels, $access)) echo 'checked';
                                @endphp>
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