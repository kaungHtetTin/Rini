@extends('admin.master')
@section('content')
 
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

    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Cost</h1>
             
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

        <div class="card" style="padding:20px;">

            <form action="{{route('admin.financials.store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <span>Title</span>
                    <input class="form-control" type="text" name="title" id="">
                    <p class="error">{{$errors->first('title')}}</p>
                </div>

                <div class="mb-3">
                    <span>Amount</span>
                    <input class="form-control" type="text" name="amount" id="">
                    <p class="error">{{$errors->first('amount')}}</p>
                </div>

                <div class="mb-3">
                    <span>Select a category</span> <a href="{{route('admin.cost-categories')}}" class="btn btn-primary add">Add New Category</a>
                    <select class="form-control" name="category_id" id="">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category}}</option>
                        @endforeach
                    </select>
                    <p class="error">{{$errors->first('category_id')}}</p>
                </div>
               
                 <button id="btn_add" class="btn btn-primary" style="float:right;">Add Now</button>
            </form>
            
        </div>
    </div>
@endsection