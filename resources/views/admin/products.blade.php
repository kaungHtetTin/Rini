@extends('admin.master')
@section('content')
    <style>
        .product{
            margin:auto;
            width: 200px;
            padding: 5px;
            cursor: pointer;
            position: relative;
        }

        /* .product:hover{
            background: #e6f1ff
        } */

        .product img{
            width: 100%;
            height: 250px;
            border-radius: 7px;
        }

        .product .description{
            color: #333;
            text-align: center;
            padding: 10px;
            position: relative;
        }
        .product .description span{
            position: absolute;
            right: 0;
            margin-right: 10px;
        }

        .product .edit-menu{
            text-align: center;
        }
        .product .edit-menu a{
            margin: 7px;
            border-radius: 50%;
            color: white;
            width: 40px;
            height: 40px;
        }
        .product .instock{
            background: red;
            padding:4px;
            border-radius: 10px;
            color: white;
            font-size: 12px;
            position: absolute;
            margin:5px;
            border:2px solid white;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Products</h1>
            <a href="{{route('admin.products-add')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Add New</a>
        </div>

        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        @if (count($products)>0)
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card product" style="{{$product->disable == 1 ? 'background:#ddd':''}}">
                            @if ($product->instock==1)
                                 <span class="instock">Instock</span>
                            @endif
                            <img src="https://www.riniforyou.com/storage/app/public/{{$product->image_url}}" alt="" srcset="">
                            <div class="description">
                                {{$product->title}} <br>
                                <strong>{{$product->price}} Ks</strong> <br>
                                {{-- <span>
                                    <i class="fas fa-cart-plus "></i>
                                </span> --}}
                            </div>
                            <div class="edit-menu">
                                <a href="{{route('admin.products-edit',$product->id)}}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if ($product->disable == 0)
                                    <a class="btn btn-danger" href="#" data-toggle="modal" 
                                                data-target="#disable-modal-{{$product->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @else
                                    <a class="btn btn-success" href="#" data-toggle="modal" 
                                                data-target="#activate-modal-{{$product->id}}">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @endif
                                
                            </div>
                        </div>
                        <br>
                    </div>

                    <div class="modal fade" id="disable-modal-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Disable Product</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="alert alert-warning">
                                    Do you really want to disable this product.
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <form action="{{route('admin.products-manage-status',$product->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="1">
                                        <button class="btn btn-danger">Disable</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="activate-modal-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Activate Product</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="alert alert-info">
                                    Do you really want to activate this product?
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <form action="{{route('admin.products-manage-status',$product->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="0">
                                        <button class="btn btn-success">Activate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            
            <div style="text-align: center;padding:100px;">
             
                <h4> <i class="fas fa-parking"></i> No product</h4><br>
                <a href="{{route('admin.products-add')}}" class="btn btn-primary"> Add New</a>
            </div>
        @endif
    </div>
@endsection