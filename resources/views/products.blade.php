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
  .product .description .cart{
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

  .categories{
    margin-top:15px;
  }
  .categories a{
    border: 1px solid #f89cab;
    border-radius: 5px;
    color: #f89cab;
    text-decoration: none;
  }

  .categories .active{
    color: white;
    background: #f89cab;
  }

  .categories a:hover{
    background: #f89cab31;
    color:#f89cab !important;
  }

  
</style>
    <div class="container">
      <div class="categories">
        <a href="{{route('products')}}" class="btn @php echo( $category_id==0 ?'active':'') @endphp">All</a>
        @foreach ($categories as $category)
            <a href="?category_id={{$category->id}}" class="btn @php echo( $category_id==$category->id ?'active':'') @endphp">{{$category->category}}</a>
        @endforeach
      </div>
    </div>
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Products
                </h2>
            </div>
            //
            <div class="row">
                @foreach ($products as $product)
                      <div class="col-sm-6 col-6 col-md-4 col-lg-3">
                        <a href="{{route('products-show',$product->id)}}">
                          <div class="btn card product">
                              <img src="http://localhost/rini/storage/app/public/{{$product->image_url}}" alt="" srcset="">
                              <div class="description">
                                  {{$product->title}} <br>
                                  
                                  <span class="cart">
                                      <i class="fas fa-cart-plus "></i>
                                  </span>
                                  @if ($product->instock==1)
                                    <span class="instock">Instock</span>
                                  @endif
                                  <br>
                              </div>
                          </div>
                        </a>
                        <br>
                    </div>
                @endforeach
            </div>
           
        </div>
    </section>

  <!-- end shop section -->
  
  <br><br>

@endsection
