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
                   Trade Now
                </h2>
            </div>

            <form id="form_search" class="search-form" action="" method="get">
                <input type="text" placeholder="Enter your phone number" name="phone" value="">
                <div id="btn_search"><i class="fas fa-search"></i></div>
            </form>
            <br><br>
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
