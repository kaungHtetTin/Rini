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
            <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
             
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
            <span style="margin-bottom: 3px;">Product Image (Portrait)</span>
            <div id="canvas-container" class="mb-3">
                <canvas id="canvas"></canvas>
                <div id="crop-area" style="display:none"></div>
            </div>
            <canvas id="cropped-canvas" style="display:none"></canvas>
            <p class="error">{{$errors->first('title')}}</p>

            <form action="{{route('admin.products-add')}}" method="post" enctype="multipart/form-data" id="submit_form">
                @csrf
                <div class="mb-3">
                    <span>Product Title</span>
                    <input class="form-control" type="text" name="title" id="">
                    <p class="error">{{$errors->first('title')}}</p>
                </div>

                <div class="mb-3">
                    <span>Product Description</span>
                    <textarea class="form-control" name="description" id="" cols="30" rows="5"></textarea>
                    <p class="error">{{$errors->first('description')}}</p>
                </div>

                <div class="mb-3">
                    <span>Select a category</span> <a href="{{route('admin.product-categories')}}" class="btn btn-primary add">Add New Category</a>
                    <select class="form-control" name="category_id" id="">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category}}</option>
                        @endforeach
                    </select>
                    <p class="error">{{$errors->first('category_id')}}</p>
                </div>
               
                 <div class="mb-3">
                    <span>Trade Price</span>
                    <input class="form-control" type="text" name="trade_price" id="">
                    <p class="error">{{$errors->first('trade_price')}}</p>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-6 col-md-6">
                        <span>Price</span>
                        <input class="form-control" type="text" name="price" id="">
                        <p class="error">{{$errors->first('price')}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <span>Discount (In percent)</span>
                        <input class="form-control" type="text" name="discount" id="" value="0">
                        <p class="error">{{$errors->first('discount')}}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="instock">Instock</label>
                    <input class="" type="checkbox" name="instock" id="">
                </div>
                <input type="file" id="cropped-image-file" style="display: none;" name="image" accept=".jpg, .jpeg, .png">
            </form>
            <input type="file" name="image" id="upload-image" style="display: none" accept=".jpg, .jpeg, .png">
            <button id="btn_add" class="btn btn-primary" style="float:right;">Add Now</button>
        </div>
    </div>

    <script>

        $(document).ready(()=>{
            $('#icon_plus').click(()=>{
                $('#upload-image').click();
            })
            $('#canvas').click(()=>{
                $('#upload-image').click();
            })
            $('#btn_add').click(()=>{
                cropImageAndPutToInput(()=>{
                    $('#submit_form').submit();
                });
            })
        })

        //Image cropper
        document.getElementById('upload-image').addEventListener('change', function (e) {
            $('#icon_plus').hide();
            const file = e.target.files[0];
            const reader = new FileReader();
            document.getElementById('crop-area').setAttribute('style','display:block');

            reader.onload = function (event) {
                const img = new Image();
                img.onload = function () {
                    const canvas = document.getElementById('canvas');
                    const ctx = canvas.getContext('2d');
                    const maxWidth = 200;
                    const scale = maxWidth / img.width;

                    const displayWidth = maxWidth;
                    const displayHeight = img.height * scale;

                    // Set the display size
                    canvas.style.width = displayWidth + 'px';
                    canvas.style.height = displayHeight + 'px';

                    // Set the actual canvas size to the original image size
                    canvas.width = img.width;
                    canvas.height = img.height;
            
                    ctx.drawImage(img, 0, 0, img.width, img.height);

                    initCropArea(displayWidth, displayHeight);
                }
                img.src = event.target.result;
            }

            reader.readAsDataURL(file);
        });

        function initCropArea(displayWidth, displayHeight) {
            const cropArea = document.getElementById('crop-area');
            const canvasContainer = document.getElementById('canvas-container');
            const canvas = document.getElementById('canvas');

            cropArea.style.width = '200px';
            cropArea.style.height = '250px';

            
            cropArea.style.left = '0px';
            cropArea.style.top = '0px';

            cropArea.onmousedown = function (e) {
                e.preventDefault();

                let shiftX = e.clientX - cropArea.getBoundingClientRect().left;
                let shiftY = e.clientY - cropArea.getBoundingClientRect().top;

                document.onmousemove = function (e) {
                    let newLeft = e.clientX - shiftX - canvasContainer.getBoundingClientRect().left;
                    let newTop = e.clientY - shiftY - canvasContainer.getBoundingClientRect().top;

                    newLeft = Math.max(0, Math.min(newLeft, displayWidth - cropArea.clientWidth));
                    newTop = Math.max(0, Math.min(newTop, displayHeight - cropArea.clientHeight));

                    cropArea.style.left = newLeft + 'px';
                    cropArea.style.top = newTop + 'px';
                }

                document.onmouseup = function () {
                    document.onmousemove = null;
                    document.onmouseup = null;
                }
            }

            cropArea.ontouchstart = function (e){
                console.log('ontouch start');
                e.preventDefault();
                let shiftX = e.targetTouches[0].clientX - cropArea.getBoundingClientRect().left;
                let shiftY = e.targetTouches[0].clientY - cropArea.getBoundingClientRect().top;

                document.ontouchmove = function (e) {
            
                    let newLeft = e.targetTouches[0].clientX - shiftX  - canvasContainer.getBoundingClientRect().left;
                   
                    let newTop = e.targetTouches[0].clientY - shiftY  - canvasContainer.getBoundingClientRect().top;
                
                    newLeft = Math.max(0, Math.min(newLeft, displayWidth - cropArea.clientWidth));
                    newTop = Math.max(0, Math.min(newTop, displayHeight - cropArea.clientHeight));

                    cropArea.style.left = newLeft + 'px';
                    cropArea.style.top = newTop + 'px';
                }

                document.ontouchend = function () {
                    document.ontouchmove = null;
                    document.ontouchend = null;
                }

            }

            cropArea.ondragstart = function (e) {
            console.log('ondrag');
            }
        }

        function cropImageAndPutToInput(onComplete){
            const cropArea = document.getElementById('crop-area');
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');

            const cropCanvas = document.getElementById('cropped-canvas');
            const cropCtx = cropCanvas.getContext('2d');

            const displayWidth = parseInt(canvas.style.width);
            const displayHeight = parseInt(canvas.style.height);
            const actualWidth = canvas.width;
            const actualHeight = canvas.height;

            const scaleX = actualWidth / displayWidth;
            const scaleY = actualHeight / displayHeight;

            const cropX = parseInt(cropArea.style.left) * scaleX;
            const cropY = parseInt(cropArea.style.top) * scaleY;
            const cropWidth = cropArea.clientWidth * scaleX;
            const cropHeight = cropArea.clientHeight * scaleY;

            cropCanvas.width = cropWidth;
            cropCanvas.height = cropHeight;

            
            const imageData = ctx.getImageData(cropX, cropY, cropWidth, cropHeight);
            cropCtx.putImageData(imageData, 0, 0);

            // Convert the cropped canvas to a data URL and create a new File object
            cropCanvas.toBlob(function(blob) {
                const file = new File([blob], "cropped-image.png", { type: "image/png" });

                // Create a new DataTransfer object and add the file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                // Set the file to the hidden input element
                const croppedImageFileInput = document.getElementById('cropped-image-file');
                croppedImageFileInput.files = dataTransfer.files;
                
                onComplete();

            });
        }

    </script>
@endsection