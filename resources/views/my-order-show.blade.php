@extends('master')
@section('content')
<style>
table img{
    width: 30px;
    height:30px;
    border-radius: 5px;
    border: 1px solid #f89cab;
}
table tr td{
    padding:7px;
}

.minus{
    cursor: pointer;
    height:30px;
    width: 30px;
    border: 1px solid #f89cab;
    text-align: center;
    border-radius: 50%;
    color: #f89cab;
    padding-top:3px;
}
.plus{
    cursor: pointer;
    height:30px;
    width: 30px;
    border: 1px solid #f89cab;
    text-align: center;
    border-radius: 50%;
    color: #f89cab;
    padding-top:3px;
}

.buy {
    padding: 8px 35px;
    outline: none;
    border: none;
    color: #ffffff;
    background: #f89cab;
    margin-top: 15px;
    border: 1px solid #f89cab;
    text-transform: uppercase;
    border-radius: 5px;
    margin: 7px;
    cursor: pointer;
}

.buy:hover {
    padding: 8px 35px;
    outline: #f89cab;
    color: #f89cab;
    margin-top: 15px;
    text-transform: uppercase;
    border-radius: 5px;
    margin: 7px;
    background: white;
    cursor: pointer;
}
.total{
    border: 1px solid #f89cab;
    border-radius: 7px;
    background: #f89cab;
    color: white;
}

#total_amount{
    font-weight: bold;
}

.error{
    color: red;
    font-size: 14px;
}

.payment{
    border: 1px solid #777;
    padding:5px;
    text-align: center;
    cursor: pointer;
    color: #777;
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

</style>

    <form id="csrf_form" action="" method="post">
        @csrf
    </form>

    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Detail
                </h2>
            </div>
            <div class="card" style="padding:10px;">
                <div class="voucher-info">
                    <div>Date - <strong>{{$voucher->created_at->diffforHumans()}}</strong></div>
                    <div class="Address">Address - <strong>{{$voucher->customer->address}}</strong></div>
                    <div class="status">Status - 
                        @if ($voucher->payment_verified == 1)
                            <strong class="text-success">Payment Verified <i class="fas fa-check-circle"></i> </strong>
                        @else
                            <strong>In Payment Verification Process</strong>
                        @endif

                        @if ($voucher->delivered == 1)
                            | <strong class="text-primary">Delivered</strong>
                            
                        @endif

                         @if ($voucher->trade == 1)
                                <div style="padding:3px; background:red;color:white;font-size:10px;font-weight:bold;width:38px;border-radius:5px;">
                                    Trade
                                </div>
                            @endif
                            
                    </div>
                </div>
                <br>
                <section class="contact_section ">
                    <table style="width:100%;margin-bottom:20px;s">
                        <thead>
                            <th colspan="2">Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </thead>
                        <tbody id="product_container">
                            @php
                                $total_amount = 0;
                            @endphp
                            @foreach ($voucher->voucher_items as $item)
                                @php
                                    $amount = $item->price * $item->quantity;
                                    $total_amount +=$amount;
                                @endphp
                                <tr>
                                    <td><img src="http://localhost/rini/storage/app/public/{{$item->product->image_url}}" alt=""></td>
                                    <td>{{$item->product->title}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->price}} ks</td>
                                    <td>{{$amount}} ks</td>
                                </tr> 
                            @endforeach
                            <tr class="total">
                                <td colspan="4"><strong>Total</strong></td>
                                <td><span id="total_amount">{{$total_amount}} ks</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div align="right">
                        Thanks
                    </div>
                </section>
            </div>
            <br>
            @if ($voucher->message != "" && $voucher->message != " ")
                <div class="alert alert-success">
                    <span>{{$voucher->message}}</span>
                    <div style="text-align:right;font-size:14px;"> {{$voucher->updated_at->diffforHumans()}}</div>
                </div>
            @endif
        </div>
    </section>

  <!-- end shop section -->
  <br><br>

@endsection
