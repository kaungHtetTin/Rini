@php
    if (!function_exists('searchSetting')) {
        function searchSetting($content,$settings){
            foreach ($settings as $key => $setting) {
                if($content == $setting->content){
                return $setting->value;
                }
            }
            return $content.' is not defined';
        }
    }
@endphp
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
            <h1 class="h3 mb-0 text-gray-800">Update Contact</h1>
        </div>
        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif
        <div class="card" style="padding:20px;">
            <form action="" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <span>Address</span>
                    <input class="form-control" type="text" name="address" id="" value="{{searchSetting('address',$settings)}}">
                    <p class="error">{{$errors->first('address')}}</p>
                </div>

                <div class="mb-3">
                    <span>Phone</span>
                    <input class="form-control" type="text" name="phone" id="" value="{{searchSetting('phone',$settings)}}">
                    <p class="error">{{$errors->first('phone')}}</p>
                </div>

                <div class="mb-3">
                    <span>Email</span>
                    <input class="form-control" type="text" name="email" id="" value="{{searchSetting('email',$settings)}}">
                    <p class="error">{{$errors->first('email')}}</p>
                </div>

                <div class="mb-3">
                    <span>Facebook</span>
                    <input class="form-control" type="text" name="facebook" id="" value="{{searchSetting('facebook',$settings)}}">
                    <p class="error">{{$errors->first('facebook')}}</p>
                </div>

                <div class="mb-3">
                    <span>Youtube</span>
                    <input class="form-control" type="text" name="youtube" id="" value="{{searchSetting('youtube',$settings)}}">
                    <p class="error">{{$errors->first('youtube')}}</p>
                </div>

                <div class="mb-3">
                    <span>Tiktok</span>
                    <input class="form-control" type="text" name="tiktok" id="" value="{{searchSetting('tiktok',$settings)}}">
                    <p class="error">{{$errors->first('tiktok')}}</p>
                </div>

                <div class="mb-3">
                    <span>Instagram</span>
                    <input class="form-control" type="text" name="instagram" id="" value="{{searchSetting('instagram',$settings)}}">
                    <p class="error">{{$errors->first('instagram')}}</p>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>

            </form>
        </div>
    </div>
@endsection