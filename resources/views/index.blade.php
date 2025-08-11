@extends('master')
@section('content')
<style>
  .product{
    margin:auto;
    padding: 5px;
    cursor: pointer;
    position: relative;
    color: #333;
  }
  .product:hover{
    background: #f89cab31;
    color:#f89cab !important;
  } 

  .product img{
    border-radius: 7px;
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

  .error{
    color: red;
      font-size: 14px;
  }

   .my-card{
        padding:5px;
        cursor: pointer;
        color:#333;
    }

    .my-card:hover{
        background: #f89cab31;
        color:#f89cab !important;
    }
    .my-card img{
        width: 100%;
        border-radius: 5px;
        display: inline;
    }

    .my-card .date{
        color:#777;
        font-size: 14px;
    }

    .my-card .short{
        color:#333;
        font-size: 14px;
    }

    .my-card .title{
        color:#333;
        font-size: 16px;
        font-weight: 500;
    }

    .read {
        padding: 4px 10px;
        outline: none;
        border: none;
        text-align: center;
        width: 120px;
        color: #ffffff;
        background: #f89cab;
        margin-top: 15px;
        margin-bottom: 5px;
        border: 1px solid #f89cab;
        border-radius: 5px;
        cursor: pointer;
    }


</style>

  
  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Latest Products
        </h2>
      </div>
    
      <div class="row">
        @foreach ($products as $product)
            <div class="col-sm-6 col-6 col-md-4 col-lg-3">
              <a href="{{route('products-show',$product->id)}}" style="text-decoration: none">
                <div class="btn card product">
                    
                    <img src="https://www.riniforyou.com/storage/app/public/{{$product->image_url}}" alt="" srcset="">
                    <div class="description">
                        {{$product->title}} <br>
                        <strong>{{$product->price}} Ks</strong>
                        <span class="cart">
                            <i class="fas fa-cart-plus "></i>
                        </span>
                        @if ($product->instock==1)
                          <span class="instock">Instock</span>
                        @endif
                    </div>
                </div>
              </a>
              <br>
            </div>
        @endforeach
      </div>

      <div class="btn-box">
        <a href="{{route('products')}}">
          View All Products
        </a>
      </div>
    </div>
  </section>

  <!-- end shop section -->

  <!-- saving section -->

  <section class="saving_section ">
    <div class="box">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="img-box">
              <img src="{{asset('images/saving-img.png')}}" alt="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="detail-box">
              <div class="heading_container">
                <h2>
                  Rini's Goal
                </h2>
              </div>
              <p>
                To become the leading clothing store in offering high-quality, affordable fashion with the latest designs, while providing exceptional customer service that ensures every shopper feels valued and satisfied.
              </p>
              <div class="btn-box">
                <a href="{{route('buy-now')}}" class="btn1">
                  Buy Now
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end saving section -->

  <!-- why section -->
  <section class="why_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Payment Methods
        </h2>
      </div>
      <div class="row">
        @foreach ($payment_methods as $method)
          <div class="col-md-4">
            <div class="box ">
              <div class="img-box">
               <img src="{{asset($method->mobile_banking->icon)}}" alt="" srcset="" style="width:60px;border-radius:5px;">

              </div>
              <div class="detail-box">
                <h5>
                  {{$method->phone}}
                </h5>
                <p>
                  {{$method->mobile_banking->bank}}
                </p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- end why section -->

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          RINI Blogs
        </h2>
      </div>
    
      <div class="row">
         @foreach ($blogs as $blog)
              <div class="col-lg-4 col-md-6 col-sm-6">
                  <div class="card" style="margin-bottom: 5px;">
                      <a href="{{route('blogs.show',$blog->id)}}" style="text-decoration: none">
                          <div class="my-card">
                              <img src="https://www.riniforyou.com/storage/app/public/{{$blog->image_url}}" alt=""> 
                              <div>
                                  <div class="title mt-3">{{$blog->title}}</div>
                                  <div class="short">{{$blog->short_description}}</div>
                                  <div class="date">{{$blog->created_at->diffforHumans()}}</div>
                                  <div class="read">Read More</div>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>
          @endforeach
      </div>

      <div class="btn-box">
        <a href="{{route('blogs')}}">
          View All Blogs
        </a>
      </div>
    </div>
  </section>


  <!-- client section -->
  <section class="client_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Reviews
        </h2>
      </div>
    </div>
    <div class="container px-0">
      <div id="customCarousel2" class="carousel  carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
          @foreach ($reviews as $key=>$review)
              <div class="carousel-item @php if($key==0) echo 'active' @endphp">
                <div class="box">
                  <div class="client_info">
                    <div class="client_name">
                      <h5>
                        {{$review->customer->name}}
                      </h5>
                      <h6>
                        {{$review->created_at->diffForHumans()}}
                      </h6>
                    </div>
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                  </div>
                  <p>
                    {{$review->message}}
                  </p>
                </div>
              </div>
          @endforeach
        </div>
        <div class="carousel_btn-box">
          <a class="carousel-control-prev" href="#customCarousel2" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#customCarousel2" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- end client section -->

    <section class="contact_section ">
    <div class="container px-0">
      <div class="heading_container ">
        <h2 class="">
          Give A Review
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="">
        <div class="">
           @if (session('msg'))
              <div class="alert alert-success">
                  {{session('msg')}}
              </div>
          @endif
          <form action="{{route('reviews.store')}}" method="POST">
            @csrf
            <div>
              <span class="error">{{$errors->first('phone')}}</span>
              <input type="text" placeholder="Phone" name="phone"/>
            </div>

            <div>
              <span class="error">{{$errors->first('name')}}</span>
              <input type="text" placeholder="Name" name="name" />
            </div>
            
            <div>
              <span class="error">{{$errors->first('message')}}</span>
              <input type="text" class="message-box" placeholder="Write your review" name="message"/>
            </div>
            <div class="d-flex ">
              <button>
                SEND
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <br><br>
  </section>

@endsection
