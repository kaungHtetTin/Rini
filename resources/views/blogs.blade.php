@extends('master')
@section('content')
<style>
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

    #pager{
        margin-top:20px;
    }

    #pager a{
        text-decoration: none;
        border: 1px solid #f89cab;
        padding: 15px;
        border-radius: 50%;
        color: #f89cab;
    }

    #pager a:hover{
        background: #f89cab;
        color: white;
    }

    #pager a i{
        width: 20px;
        height: 20px;
        text-align: center;
    }
  
    #pager span{
        margin-left : 10px;
        margin-right: 10px;
        border: 1px solid #f89cab;
        color: #f89cab;
        padding:15px;
        border-radius: 10px;
        font-weight: bold;

    }

</style>
    
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
            <div id="pager">
                
            </div>
           
        </div>
    </section>
  
  <br><br>
  <script>
    let collections = @json($blogs);
    console.log(collections);
    $(document).ready(()=>{
        $('#pager').html(setPageNavigator(collections));
    })

    function setPageNavigator(collections){

        let navigatorHtml = "";

        let current_page = collections.current_page;
        let last_page = collections.last_page;
        let next_page_url = collections.next_page_url;
        let prev_page_url = collections.prev_page_url;

        if(last_page == 1) return navigatorHtml;

        if(prev_page_url!=null){
            navigatorHtml+= `<a href="${prev_page_url}"><i class="fas fa-backward"></i></a>`;
        }
        navigatorHtml += `<span id="page_number">${current_page}</span>`;
        if(next_page_url!=null){
            navigatorHtml += `<a id="backward_page" href="${next_page_url}"><i class="fas fa-forward"></i></a>`;
        }

        return navigatorHtml;

    }
     
  </script>

@endsection
