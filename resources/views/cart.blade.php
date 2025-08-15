@extends('master')
@section('content')
<style>
  .product{
    padding: 5px;
    cursor: pointer;
  }
  .product:hover{
    background: #f89cab31;
    color:#f89cab !important;
  } 

  .product img{
    border-radius: 7px;
    width: 100%;
  }

  .product .description{
    text-align: center;
    padding: 10px;
    position: relative;
  }
  .product .description span{
    position: absolute;
    right: 0;
    margin-right: 10px;
  }

  .product .description .instock{
      background: red;
      padding:3px;
      border-radius: 10px;
      color: white;
      font-size: 10px;
      font-weight: bold;
      position: absolute;
      left:0;
  }
  
  #nothing_box{
    text-align: center;
    color:#999;
    font-size: 20px;
  }
</style>

    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    My Cart
                </h2>
            </div>
            <div class="row" id="product_container">
                 
            </div>

            <div id="nothing_box" style="display: none">
              <br><br>
                <i class="fas fa-cart-plus" style="font-size:40px;"></i> <br>
                No item! <br>
                Select and add item to your cart.
            </div>
            
            <div class="btn-box" id="btn_buy" style="display: none">
                <a href="{{route('buy')}}">
                    Buy Now
                </a>
            </div>
        </div>
    </section>

  <!-- end shop section -->
  <br><br>

  <script>
    let products = window.localStorage.getItem('rini_cart');
    let delete_id = 0;
    if(products != null){
        products = JSON.parse(products);

        setProduct(products);
    }

    $(document).ready(()=>{
      if(products.length>0){
        $('#btn_buy').show();
        $('#nothing_box').hide();
      }else{
        $('#btn_buy').hide();
        $('#nothing_box').show();
      }
    })

    function setProduct(products){
        $('#product_container').html("")
        products.map((product)=>{
            $('#product_container').append(`
                <div class="col-sm-6 col-4 col-md-3 col-lg-3">
                    <div class="btn card product">
                        <img src="https://www.riniforyou.com/storage/app/public/${product.image_url}" alt="" srcset="">
                        <div class="description">
                            ${product.title} <br>
                            
                            <span onclick="removeProduct(${product.id})">
                                <i class="fas fa-trash "></i>
                            </span>
                            <br>
                        </div>
                    </div>
                    <br>
                </div>
            `);
        })
    }

    function removeProduct(id){
      delete_id = id;
      products = products.filter( p => p.id !== id);
      setProduct(products);
      window.localStorage.setItem('rini_cart',JSON.stringify(products));
    }

  </script>

@endsection
