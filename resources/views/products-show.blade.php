@extends('master')
@section('content')
<style>

.product{
    padding:15px;
}

.product img{
    width: 100%;
    border-radius: 10px;
    border: 3px solid #f89cab;
}

.info .title{
    font-size: 20px;
}

.info .category{
    color: #777
}

.info .price{
    font-weight: bolder;
}

.product .info div{
    margin:7px;
}



.image-box div{
    display: inline;
    position: relative;
}

.image-box div span{
    height: 40px;
    width: 40px;
    border-radius: 50%;
    position: absolute;
    left: 110px;
    top: -55px;
}

.image-box div a{
    height: 40px;
    width: 40px;
    border-radius: 50%;
    position: absolute;
    left: 110px;
    top: -55px;
}

.image-box img{
    width: 150px;
    margin: 5px;
    border-radius:5px;
    cursor: pointer;
}

.product .buy {
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

.product .cart {
    padding: 8px 35px;
    margin-top: 15px;
    color:#f89cab;
    text-transform: uppercase;
    border: 1px solid #f89cab;
    border-radius: 5px;
    cursor: pointer;
    margin: 7px;
}

.product .cart:hover {
    padding: 8px 35px;
    outline: none;
    border: none;
    color: #ffffff;
    background: #f89cab;
    margin-top: 15px;
    border: 1px solid #f89cab;
    text-transform: uppercase;
    border-radius: 5px;
}

.instock{
      background: red;
      padding:3px;
      border-radius: 10px;
      color: white;
      font-size: 10px;
      font-weight: bold;
  }

</style>
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    {{$product->title}}
                </h2>
            </div>
            <div class="product">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6" >
                        <img src="https://www.riniforyou.com/storage/app/public/{{$product->image_url}}" alt="">
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="info">
                            <div class="title">{{$product->title}} </div>
                            <div class="category"><i>{{$product->product_category->category}}</i></div>
                            <div class="description">{{$product->description}}</div>
                            <div class="price">{{$product->price}} Ks</div>
                            <div> @if ($product->instock==1)
                                 <span class="instock">Instock</span>
                            @endif</div>
                            <br>
                            <span id="btn_buy" class="buy">Buy Now</span>
                            <span id="btn_cart" class="cart">Add to Cart</span>
                        </div>
                    </div>
                </div>
                
            </div>
            @if (count($product->product_images)>0)
                <div class="card gallary" style="padding:20px;">
                    @if (session('imageMsg'))
                        <div class="alert alert-success">
                            {{session('imageMsg')}}
                        </div>
                    @endif
                    <h5>Image Gallery</h5>
                    <div class="image-box">
                        @foreach ($product->product_images as $image)
                            <div>
                                <img src="https://www.riniforyou.com/storage/app/public/{{$image->image_url}}" id="" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
           
        </div>
    </section>

  <!-- end shop section -->
  <br><br>

  <script>
    let buy_url = "{{route('products-buy',$product->id)}}"
    let product = @json($product);
    let my_products = window.localStorage.getItem('rini_cart');
    let isIncard = false;
    if(my_products == null){
        my_products = [];
    }else{
        my_products = JSON.parse(my_products);
        isIncard = my_products.find(p => p.id === product.id)
    }
    console.log(my_products);
    
    
    $(document).ready(()=>{
        $('#btn_cart').click(()=>{
            if(!isIncard){
                product.quantity = 1;
                my_products.push(product);
                window.localStorage.setItem('rini_cart', JSON.stringify(my_products));
            }
            window.location.href="{{route('cart')}}"
        })

        $('#btn_buy').click(()=>{
            window.location.href = buy_url;
        })
    })
     
  </script>

@endsection
