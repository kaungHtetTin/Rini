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

    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Employee</h1>
             
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
            <span style="margin-bottom: 3px;">Profile (Square)</span>
            <div id="image-container">
                        <img src="http://localhost/rini/storage/app/public/{{$employee->image_url}}" alt="">
                <span id="btn-select-image" class="btn btn-secondary"><i class="fas fa-edit"></i></span>
            </div>
            <div id="canvas-container" class="mb-3" style="display: none">
                <canvas id="canvas"></canvas>
                <div id="crop-area" style="display:none"></div>
            </div>
            <canvas id="cropped-canvas" style="display:none"></canvas>
            <p class="error">{{$errors->first('title')}}</p>

            <form action="{{route('admin.employees.modify',$employee->id)}}" method="post" enctype="multipart/form-data" id="submit_form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <span>Name</span>
                    <input class="form-control" type="text" name="name" id="" value="{{$employee->name}}">
                    <p class="error">{{$errors->first('name')}}</p>
                </div>

                <div class="mb-3">
                    <span>Phone</span>
                    <input class="form-control" type="text" name="phone" id="" value="{{$employee->phone}}">
                    <p class="error">{{$errors->first('phone')}}</p>
                </div>

                <div class="mb-3">
                    <span>Email (Optional)</span>
                    <input class="form-control" type="text" name="email" id="" value="{{$employee->email}}">
                    <p class="error">{{$errors->first('email')}}</p>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-6 col-md-6">
                        <span>NRC ID</span>
                        <input class="form-control" type="text" name="nrc_id" id="" value="{{$employee->nrc_id}}">
                        <p class="error">{{$errors->first('nrc_id')}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <span>Salary Amount</span>
                        <input class="form-control" type="text" name="salary" id="" value="{{$employee->salary}}">
                        <p class="error">{{$errors->first('salary')}}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <span>Address</span>
                    <textarea class="form-control" name="address" id="" cols="30" rows="5">{{$employee->address}}</textarea>
                    <p class="error">{{$errors->first('address')}}</p>
                </div>

                <div class="mb-3">
                    <span>Select a department</span> <a href="{{route('admin.departments')}}" class="btn btn-primary add">Add New Department</a>
                    <select class="form-control" name="department_id" id="">
                        @foreach ($departments as $department)
                            <option {{$employee->department_id == $department->id ? 'selected' : ''}} value="{{$department->id}}">{{$department->department}}</option>
                        @endforeach
                    </select>
                    <p class="error">{{$errors->first('department_id')}}</p>
                </div>
               
                <input type="file" id="cropped-image-file" style="display: none;" name="image" accept=".jpg, .jpeg, .png">
            </form>
            <input type="file" name="image" id="upload-image" style="display: none" accept=".jpg, .jpeg, .png">
            <button id="btn_add" class="btn btn-primary" style="float:right;">Add Now</button>
        </div>
    </div>

    <script>

        $(document).ready(()=>{
            $('#btn-select-image').click(()=>{
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
            $('#image-container').hide();
            $('#canvas-container').show();
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

            if(displayHeight>260){
                cropArea.style.width = '250px';
                cropArea.style.height = '250px';
            }else{
                cropArea.style.width = (displayHeight-10)+'px';
                cropArea.style.height = (displayHeight-10)+'px';
            }

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

            
            try {
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
            } catch (error) {
                
                onComplete();
                return;
            }
        }

    </script>
@endsection