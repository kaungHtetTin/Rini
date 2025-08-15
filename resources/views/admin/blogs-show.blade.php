@extends('admin.master')
@section('content')
    <style>
        .blog{

        }
        .blog img{
            width: 100%;
            border-radius: 5px;
        }
        .blog .title{
            font-size: 18px;
            color:#333;
            font-weight: 500;
            margin-top: 10px;
        }
        .blog .short{
            padding:10px;
            margin: 5px;
            background: #f3f3f3;
            border-radius: 5px;
        }

        .latest-blog{
            display: flex;
            padding: 7px;
        }

        .latest-blog img{
            width: 50px;
            margin-right: 10px;
            border-radius: 5px;
        }
        .latest-blog .title{
            color: #333;
            font-size: 16px;
        }
        .latest-blog .date{
            color: #777;
            font-size: 14px;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail</h1>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <div class="blog">
                    <img src="https://www.riniforyou.com/storage/app/public/{{$blog->image_url}}" alt="">
                    <div class="title">{{$blog->title}}</div>
                    <div class="date">{{$blog->created_at->diffforHumans()}}</div>
                    <div class="short">{{$blog->short_description}}</div>
                    <div class="blody">@php echo $blog->body @endphp</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-12">
                <h5>Latest Blogs</h5>
                @foreach ($blogs as $lblog)
                    <div class="card" style="margin-bottom: 5px;">
                        <a href="{{route('admin.blogs.show',$lblog->id)}}" style="text-decoration: none">
                            <div class="latest-blog">
                                <img src="https://www.riniforyou.com/storage/app/public/{{$lblog->image_url}}" alt=""> 
                                <div>
                                    <div class="title">{{$lblog->title}}</div>
                                    <div class="date">{{$lblog->created_at->diffforHumans()}}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection