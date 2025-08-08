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
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">New Orders</h1>
            <a href="{{route('admin.vouchers.add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i>Add New</a>
        </div>

        <div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Adddress</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Adddress</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                            <tr>
                                <td>{{$voucher->created_at->diffForHumans()}}</td>
                                <td>{{$voucher->customer->name}}</td>
                                <td>{{$voucher->customer->phone}}</td>
                                <td>{{$voucher->total_amount}}</td>
                                <td>{{$voucher->customer->address}}</td>
                                <td>
                                    @if ($voucher->payment_verified==1)
                                        <span class="text-success">Verified</span>
                                    @else
                                        Processing
                                    @endif
                                    @if ($voucher->delivered==1)
                                        <span class="text-primary">Delivered</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-primary action-button" href="{{route('admin.vouchers.detail',$voucher->id)}}"> View </a>
                                </td>
                            </tr>
                            <form id="form_delivered_{{$voucher->id}}" action="{{route('admin.vouchers.delivered',$voucher->id)}}" method="post" style="display:none">
                                @csrf
                                @method('PUT')
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{$vouchers->links()}}
        </div>

    </div>
    <script>
        $(document).ready(()=>{
            
        })

        function delivered(id){
            $('#form_delivered_'+id).submit();
        }
    
    </script>
@endsection