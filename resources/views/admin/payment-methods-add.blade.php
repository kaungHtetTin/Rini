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
            <h1 class="h3 mb-0 text-gray-800">Add New Payment Method</h1>
        </div>

        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        <div class="card" style="padding:20px;">
            <form action="{{route('admin.payment-methods-store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <span>Phone</span>
                    <input class="form-control" type="text" name="phone" id="" value="">
                    <p class="error">{{$errors->first('phone')}}</p>
                </div>

                 <div class="mb-3">
                    <span>Mobile Banking</span>
                    @foreach ($mobile_bankings as $banking)
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="banking_{{$banking->id}}" name="banking_{{$banking->id}}">
                                <label class="custom-control-label" for="banking_{{$banking->id}}">{{$banking->bank}}</label>
                            </div>
                        </div>
                    @endforeach
                    @if (session('banking_error'))
                        <p class="my-error"> {{session('banking_error')}}</p>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>


            </form>
        </div>

    </div>
@endsection