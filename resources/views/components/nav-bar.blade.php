<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="{{route('home')}}">
            <span>
            Rini
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""></span>
        </button>

        @if ($page_title == 'Home')
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @else
        <div class="collapse navbar-collapse innerpage_navbar" id="navbarSupportedContent">
            <style>
                .active{
                    background: #f89cab;
                    color:white !important;
                }

                .cart-active{
                    color: #f89cab;
                }
            </style>
        @endif
            <ul class="navbar-nav ">
                <li class="nav-item @php if($page_title == 'Home') echo 'active' @endphp">
                    <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @php if($page_title == 'Shop') echo 'active' @endphp" href="{{route('products')}}" >
                        Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a id="nav_my_order" class="nav-link @php if($page_title == 'My Order') echo 'active' @endphp" href="#">
                        My Order
                    </a>
                    <script>
                        let my_order_url = "{{route('vouchers')}}";
                        let phone = window.localStorage.getItem('rini_user_phone');
                        my_order_url = my_order_url+'?phone='+phone;
                        $(document).ready(()=>{
                            $('#nav_my_order').click(()=>{
                                window.location.href = my_order_url;
                            })
                        })
                    </script>
                </li>
                <li class="nav-item">
                    <a class="nav-link @php if($page_title == 'Blogs') echo 'active' @endphp" href="{{route('blogs')}}">
                        Blogs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @php if($page_title == 'Collaboration') echo 'active' @endphp" href="{{route('collaborate')}}">Collaboration</a>
                </li>
            </ul>
            <div class="user_option">
                 
                <a href="{{route('cart')}}">
                    <i class="fa fa-shopping-bag @php if($page_title == 'Cart') echo 'cart-active' @endphp" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        </nav>
    </header>
    <!-- end header section -->
    <!-- slider section -->

    @if ($page_title == 'Home')
    <section class="slider_section">
        <div class="slider_container">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-7">
                        <div class="detail-box">
                            <h1>
                            Welcome To <br>
                            Rini Campus
                            </h1>
                            <p>
                                Welcome to Rini!. Our mission is To become the leading clothing store in offering high-quality, affordable fashion with the latest designs, while providing exceptional customer service that ensures every shopper feels valued and satisfied.
                            </p>
                           
                        </div>
                        </div>
                        <div class="col-md-5 ">
                        <div class="text-center">
                            <img style="height:350px;" src="images/slider-img.png" alt="" />
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-7">
                        <div class="detail-box">
                            <h1>
                            Let's <br> Collaborate 
                            
                            </h1>
                            <p>
                            Looking to partner with like-minded collaborators who share our passion for high-quality, affordable fashion. Join us in delivering the latest trends with exceptional service, and let's create something great together!
                            </p>
                            <a href="{{route('collaborate')}}">
                                Collaborate
                            </a>
                        </div>
                        </div>
                        <div class="col-md-5 ">
                            <div class="text-center">
                                <img style="height:300px;" src="{{asset('images/my-img-1.png')}}" alt="" />
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="carousel_btn-box">
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <img src="images/line.png" alt="" />
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    <span class="sr-only">Next</span>
                </a>
                </div>
            </div>
        </div>
    </section>
     @endif
    <!-- end slider section -->
</div>