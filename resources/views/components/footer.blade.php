  @php
      
    if (!function_exists('searchSetting')) {
      function searchSetting($content,$settings){
        foreach ($settings as $key => $setting) {
          if($content == $setting->content){
            return $setting->value;
          }
        }
        return null;
      }
    }

  @endphp
  <section class="info_section  layout_padding2-top">
    <div class="social_container">
      <div class="social_box">
        @if (searchSetting('facebook',$settings)!=null)
            <a href="{{searchSetting('facebook',$settings)}}">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
        @endif
        @if (searchSetting('tiktok',$settings)!=null)
          <a href="{{searchSetting('tiktok',$settings)}}">
            <i class="fab fa-tiktok" aria-hidden="true"></i>
          </a>
        @endif

        @if (searchSetting('instagram',$settings)!=null)
          <a href="{{searchSetting('instagram',$settings)}}">
            <i class="fa fa-instagram" aria-hidden="true"></i>
          </a>
        @endif

        @if (searchSetting('youtube',$settings)!=null)
          <a href="{{searchSetting('youtube',$settings)}}">
            <i class="fa fa-youtube" aria-hidden="true"></i>
          </a>
        @endif
      </div>
    </div>
    <div class="info_container ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-4">
            <h6>
              Payment Methods
            </h6>
            <ul>
              @foreach ($payment_methods as $method)
                  <li>
                    {{$method->mobile_banking->bank}} <br>
                    <b>{{$method->phone}}</b>
                  </li>
              @endforeach
            </ul>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="info_form">
              <h6>
                Search My Orders
              </h6>
              <form action="{{route('vouchers')}}" method="get">
                <input type="text" placeholder="Enter your phone" name="phone">
                <button>
                  Search 
                </button>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <h6>
              CONTACT US
            </h6>
            <div class="info_link-box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span> {{searchSetting('address',$settings)}} </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>{{searchSetting('phone',$settings)}}</span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>{{searchSetting('email',$settings)}}</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- footer section -->
    <footer class=" footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By Rini
        </p>
      </div>
    </footer>
    <!-- footer section -->

  </section>