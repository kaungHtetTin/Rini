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
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Invoice</a>
        </div>

        <div class="card" style="padding:20px;">
            <div style="margin-bottom: 20px;">
                    Order By: <strong>{{$voucher->customer->name}}</strong> <br>
                    Phone: <strong>{{$voucher->customer->phone}}</strong> <br>
                    Address: <strong>{{$voucher->customer->address}}</strong> <br>
                    Status: 
                    @if ($voucher->payment_verified==1)
                        <strong class="text-success">Payment Verified <i class="fas fa-check-circle"></i></strong>
                    @else
                        <strong>In Payment Verification</strong>
                    @endif

                    @if ($voucher->delivered==1)
                        <strong class="text-primary">Delivered</strong>
                    @endif
                    
            </div>
            <div style="margin-bottom: 20px;">
                <a class="btn btn-primary action-button" href="http://localhost/rini/storage/app/public/{{$voucher->screenshot_url}}"> <i class="fab fa-amazon-pay"></i> Check Payment</a>
                @if ($voucher->payment_verified==0)
                    <a id="btn_payment_verified" class="btn btn-success action-button" href="#"> <i class="fas fa-check-circle"></i> Verified</a>
                @endif
                <a class="btn btn-danger action-button" href="#" data-toggle="modal" 
                        data-target="#delete-modal"> <i class="fas fa-trash"></i> Delete</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_quantity = 0;
                            $total_amount = 0;
                        @endphp
                        @foreach ($voucher->voucher_items as $item)
                            @php
                                $total_quantity += $item->quantity;
                                $total_amount += $item->amount;
                            @endphp
                            <tr>
                                <td>00{{$item->product->id}}</td>
                                <td>{{$item->product->title}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->amount}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="bg-primary" style="color:white">
                            <th colspan="3">Total</th>
                            <th>{{$total_quantity}}</th>
                            <th>{{$total_amount}}</th>
                            <th></th>
                        </tr>
                    </tfoot>

                </table>
            </div>
            @if ($voucher->message != "" && $voucher->message != " ")
                <div class="alert alert-info">
                    <span>{{$voucher->message}}</span>
                    <div style="text-align:right;font-size:14px;"> {{$voucher->updated_at->diffforHumans()}}</div>
                </div>
            @endif

            <form id="form_delivered" action="{{route('admin.vouchers.delivered',$voucher->id)}}" method="post">
                @csrf
                @method('PUT')
                <p class="error">{{$errors->first('message')}}</p>
                <input class="form-control mb-3" type="text" placeholder="Enter delivery method" name="message">
                <button class="btn btn-primary" type="submit" style="float: right">Delivered</button>
            </form>

        </div>



        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Delete Voucher</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="alert alert-warning">
                        Do you really want to delete this voucher?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <form action="{{route('admin.vouchers.delete',$voucher->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="status" value="1" value="1">
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form id="form_payment_verified" action="{{route('admin.vouchers.payment_verified',$voucher->id)}}" method="post">
            @csrf
            @method('PUT')
        </form>
        <form id="form_delivered" action="{{route('admin.vouchers.delivered',$voucher->id)}}" method="post">
            @csrf
            @method('PUT')
        </form>

    </div>
    <script>
        $(document).ready(()=>{
            $('#btn_payment_verified').click(()=>{
                $('#form_payment_verified').submit();
            });

            $('#btn_delivered').click(()=>{
                $('#form_delivered').submit();
            })


        });
    </script>
@endsection