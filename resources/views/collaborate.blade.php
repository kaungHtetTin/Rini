@extends('master')
@section('content')
<style>

  
</style>
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Collaboration
                </h2>
                <p>Welcome, and thank you for partnering with us at Rini! We value your collaboration and are committed to providing reliable, high-quality fashion to our customers. Together, we’ll ensure consistent excellence and a seamless experience for everyone involved. Let’s build something strong and lasting!</p>
            </div>
            
           
        </div>
    </section>

  <!-- end shop section -->

  <!-- gift section -->
  <section class="gift_section layout_padding-bottom">
    <div class="box ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5">
            <div class="img_container">
              <div class="img-box">
                <img src="images/gifts.png" alt="">
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="detail-box">
              <div class="heading_container">
                <h2>
                  Let's <br>
                  Collaborate
                </h2>
              </div>
              <p>
                Let’s build something strong and lasting!
              </p>
              <div class="btn-box">
                 <a href="{{route('trade')}}" class="btn2">
                  Trade Now
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end gift section -->
  
  <br><br>

@endsection
