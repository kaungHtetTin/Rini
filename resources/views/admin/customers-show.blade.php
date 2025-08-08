@extends('admin.master')
@section('content')
    <style>
        .name{
            color:#333;
            text-align: center;
        }
        .voucher{
            cursor: pointer;
            margin-bottom: 5px;
            font-size: 14px;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Customer's Detail</h1>
        </div>

        <div class="card" style="padding:20px;">
            <br><br>
            <div class="name">
                <h5>{{$customer->name}}</h5>
            </div> 
            <br><br>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <table class="table">
                        <tr>
                            <td> <i class="fas fa-phone-alt"></i> Phone </td>
                            <td>{{$customer->phone}}</td>
                        </tr>
                        <tr>
                            <td> <i class="fas fa-city"></i> Address </td>
                            <td>{{$customer->address}}</td>
                        </tr>
                    </table>
                </div>
                 
                <div class="col-lg-6 col-md-6">
                    <table class="table">
                        <tr>
                            <td> <i class="fas fa-dollar-sign"></i> Total Purchase </td>
                            <td>{{$total_purchase}} Ks</td>
                        </tr>
                        <tr>
                            <td> <i class="fas fa-comment-alt"></i> Total Review </td>
                            <td>{{$total_review}} </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <br>
        <h4 class="mb-0 text-gray-800"> Purchased History </h4>
        <br>
        <div>
            @foreach ($customer->vouchers as $voucher)
                <a href="{{route('admin.vouchers.detail',$voucher->id)}}" style="text-decoration: none; color:#777">
                    <div class="card voucher" style="padding:15px;">
                        <div class="date">Date - <strong>{{$voucher->created_at->diffforHumans()}}</strong></div>
                        <div class="total">Total Amount - <strong>{{$voucher->total_amount}} ks</strong></div>
                        
                        <div class="status">Status - 
                            @if ($voucher->payment_verified == 1)
                                <strong class="text-success">Payment Verified <i class="fas fa-check-circle"></i> </strong>
                            @else
                                <strong>In Payment Verification Process</strong>
                            @endif

                            @if ($voucher->delivered == 1)
                                | <strong class="text-primary">Delivered</strong>
                            @else
                                
                            @endif

                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
@endsection