@extends('master')
@section('content')
<style>
    .search-form{
        width: 80%;
        margin: auto;
        background: #f89cab;
        border-radius: 15px;
        padding:5px;
        display: flex;
    }
    .search-form input{
        width: 85%;
        border-radius: 10px;
        padding: 5px;
        border: 1px solid #f89cab;
        outline: #f89cab69;
    }
    .search-form div{
        cursor: pointer;
        width: 15%;
        text-align: center;
        color: white;
        padding-top: 7px;
    }

    .voucher{
        padding:10px;
        margin: 5px;
        color:#333;
        text-align: left;
    }

    .voucher:hover{
        background: #f89cab31;
        color:#f89cab !important;
    }

</style>
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                   My Order
                </h2>
            </div>

            <form id="form_search" class="search-form" action="" method="get">
                <input type="text" placeholder="Enter your phone number" name="phone" value="{{$phone}}">
                <div id="btn_search"><i class="fas fa-search"></i></div>
            </form>
            <br><br>
            @if (count($vouchers)>0)
                <div class="alert text-center">
                    Hello <strong>{{$customer->name}}</strong>, belows are the lists of your previous orders.
                </div>
                @foreach ($vouchers as $voucher)
                    <a href="{{route('vouchers.show',$voucher->id)}}">
                        <div class="btn card voucher">
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

                            @if ($voucher->trade == 1)
                                <div style="padding:3px; background:red;color:white;font-size:10px;font-weight:bold;width:38px;border-radius:5px;">
                                    Trade
                                </div>
                            @endif
                             
                        </div>
                    </a>
                    
                @endforeach
            @else
                
            @endif
            

        </div>
    </section>

  <!-- end shop section -->
  <br><br>

  <script>
    $(document).ready(()=>{
        $('#btn_search').click(()=>{
            $('#form_search').submit();
        })
    })
  </script>

@endsection
