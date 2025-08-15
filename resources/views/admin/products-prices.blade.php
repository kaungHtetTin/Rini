@extends('admin.master')
@section('content')
    <style>
        .action-button{
            padding:3px;
            font-size: 12px;
            margin:3px;
        }
        table tr td{
            font-size: 14px;
        }
        .access_level{
            margin: 3px;
            padding:3px;
            border-radius: 5px;
            display: inline;
            color: white;

        }
    </style>
 
    <style>
        .add{
            font-size: 10px;
            height: 25px;
            padding: 5px;
            float: right;
            margin-bottom: 3px;
        }

        .error{
            color:red;
            font-size: 12px;
        }

        #canvas {
            border: 1px solid #ccc;
            cursor: pointer;
        }

        #crop-area {
            border: 2px dashed #000;
            position: absolute;
            cursor: move;
        }

        #canvas-container {
            position: relative;
            width: 200px;
        }
        #cropped-canvas{
            width: 100px;
        }

        #image-container{
            position: relative;
        }

        #image-container img{
            width: 200px;
            border-radius: 10px;
            display: block
        }

        #image-container span{
            height: 40px;
            width: 40px;
            border-radius: 50%;
            position: absolute;
            left: 150px;
            bottom: 15px;
        }

        .gallary .image-picker{
            padding:50px;
            border: 1px solid gainsboro;
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


        #progress-bar{
            margin-bottom: 15px;
            margin-top: 15px;
            border-radius: 3px;
            background: #858796;
        }

        #progress{
            height:5px;
            width: 0%;
            background: #4e73df;
            border-radius: 3px;
        }

    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Price</h1>
             
        </div>
        @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
            
        @endif

        <form id="csrf_form" action="" method="post">
            @csrf
        </form>
        
        <div class="card" style="padding:20px;">
            <h5>{{$product->title}}</h5>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div id="image-container">
                        <img src="https://www.riniforyou.com/storage/app/public/{{$product->image_url}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <table width="100%">
                        <tr>
                            <td>Title</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Category </td>
                            <td>{{$product->product_category->category}} </td>
                        </tr>
                        <tr>
                            <td>Instock </td>
                            <td> 
                                @if ($product->instock)
                                    <i class="fas fa-check-circle text-success"></i>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                
            </div>
        </div>
        <br>
        <h5>Price Table</h5>
        <div class="card" style="padding:20px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($product->prices as $price)
                            <tr>
                                <td> {{$price->quantity}}</td>
                                <td>{{$price->price}}</td>
                                <td>
                                    <a class="btn btn-danger action-button" href="#" data-toggle="modal" 
                                        data-target="#disable-modal-{{$price->id}}"> Delete </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="disable-modal-{{$price->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Delete Price</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="alert alert-warning">
                                            Do you really want to delete this price?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{route('admin.prices.destroy',$price->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="status" value="1" value="1">
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <h5>Add New Price</h5>
        <div class="card" style="padding:20px;">
            <form action="{{route('admin.prices.add')}}" method="post" enctype="multipart/form-data" id="submit_form">
                @csrf
                <div class="mb-3">
                    <span>Quantity</span>
                    <input class="form-control" type="text" name="quantity" id="" value="">
                    <p class="error">{{$errors->first('quantity')}}</p>
                </div>

                <div class="mb-3">
                    <span>Price</span>
                    <input class="form-control" type="text" name="price" id="" value="">
                    <p class="error">{{$errors->first('price')}}</p>
                </div>
                <input type="hidden" name="product_id" value="{{$product->id}}">

                <button id="btn_add" class="btn btn-primary" style="width:100%">Save</button>
            </form>
          
            
        </div>

        <br>

        <br>
     
    </div>
@endsection