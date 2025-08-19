@extends('admin.master')
@section('content')
    <style>
        .action-button{
            padding:3px;
            font-size: 12px;
            margin:3px;
            float: right;
        }
        table tr td{
            font-size: 14px;
        }
        .error{
            color:red;
            font-size: 12px;
        }
    </style>

    <style>
        .payment{
            border: 1px solid #d1d3e2;
            padding:5px;
            text-align: center;
            cursor: pointer;
            color: #777;
            background: white;
            border-radius: 0.35rem;
            margin-bottom: 20px;
        }

        #add_image_icon{
            margin: 40px;
        }

        #add_image_icon i{
            font-size: 40px;
        }


        .payment:hover{
            color:#333;
        }

        .attachment{
            border: 1px solid #d1d3e2;
            padding:7px;
            cursor: pointer;
            color: #777;
            background: white;
            border-radius: 0.35rem;
            margin-bottom: 20px;
            display: block
        }

        .attachment img{
            width: 30px;
            height: 30px;
            border-radius: 5px;

        }

    </style>
    <div class="container-fluid">
        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail</h1>
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
                <a class="btn btn-primary action-button" href="https://www.riniforyou.com/storage/app/public/{{$voucher->screenshot_url}}"> <i class="fab fa-amazon-pay"></i> Check Payment</a>
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
        <br>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Attachment</h1>
        </div>

        <div>
            @foreach ($voucher->voucher_attachments as $attachment)
              
                <div class="attachment" href="">

                    <img src="https://www.riniforyou.com/storage/app/public/{{$attachment->image_url}}" alt="" srcset="">
                    
                    <a class="btn btn-danger action-button" href="#" data-toggle="modal" data-target="#disable-modal-{{$attachment->id}}"> Delete </a>
                    <a class="btn btn-primary action-button" href="https://www.riniforyou.com/storage/app/public/{{$attachment->image_url}}"> View </a>

                    <div class="modal fade" id="disable-modal-{{$attachment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Delete Attachment</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="alert alert-warning">
                                    Do you really want to disable this attachment?
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <form action="{{route('admin.voucherattachment.destroy',$attachment->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="status" value="1" value="1">
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            @endforeach
        </div>
         
        <section class="contact_section ">
            <form action="{{route('admin.voucherattachment.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input id="input_image" type="file" name="image" id="" style="display: none;" accept=".jpg, .jpeg, .png">
                <input type="hidden" value="{{$voucher->id}}" name="voucher_id">
                <span class="error" style="display:none" id="input_image_error">Please Select the payment screenshot for the order.</span>
                <div class="payment" id="add_image">
                    <div id="add_image_icon">
                        <i class="fas fa-image"></i> <br>
                        <div class="info">Add Payment Screenshot</div>
                    </div>
                    <img id="imageView" src="" alt="" style="width: 150px;">
                </div>
                <button class="btn btn-primary" type="submit" style="float: right">Add Now</button>
            </form>
            <br>
            
            <br>
        </section>

    </div>

  
    <script>
        $(document).ready(()=>{
            $('#btn_payment_verified').click(()=>{
                $('#form_payment_verified').submit();
            });

            $('#btn_delivered').click(()=>{
                $('#form_delivered').submit();
            })

            $('#add_image').click(()=>{
                $('#input_image').click();
            })

            $('#input_image').change(()=>{
                var files=$('#input_image').prop('files');
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (e)=>{
                    let src = e.target.result;
                    $('#imageView').attr('src',src);
                    $('#add_image_icon').hide();
                    $('#input_image_error').hide();
                }

                reader.readAsDataURL(file);
            })


        });
    </script>
@endsection