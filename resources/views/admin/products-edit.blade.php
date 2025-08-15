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
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
             
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
            <h5>Detail</h5>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div id="image-container">
                        <img src="https://www.riniforyou.com/storage/app/public/{{$product->image_url}}" alt="">
                        <span id="btn-select-image" class="btn btn-secondary"><i class="fas fa-edit"></i></span>
                    </div>
                     <div id="canvas-container" class="mb-3" style="display: none">
                        <canvas id="canvas"></canvas>
                        <div id="crop-area" style="display:none"></div>
                    </div>
                    <canvas id="cropped-canvas" style="display:none"></canvas>
                </div>
                <div class="col-lg-6 col-md-6">
                    <table width="100%">
                        <tr>
                            <td>Title</td>
                            <td>{{$product->title}}</td>
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
            <br><br>

            <form action="{{route('admin.products-edit',$product->id)}}" method="post" enctype="multipart/form-data" id="submit_form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <span>Product Title</span>
                    <input class="form-control" type="text" name="title" id="" value="{{$product->title}}">
                    <p class="error">{{$errors->first('title')}}</p>
                </div>

                <div class="mb-3">
                    <span>Product Description</span>
                    <textarea class="form-control" name="description" id="" cols="30" rows="5">{{$product->description}}</textarea>
                    <p class="error">{{$errors->first('description')}}</p>
                </div>

                <div class="mb-3">
                    <span>Select a category</span> <a href="{{route('admin.product-categories')}}" class="btn btn-primary add">Add New Category</a>
                    <select class="form-control" name="category_id" id="">
                        @foreach ($categories as $category)
                            <option {{$product->product_category_id == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category}}</option>
                        @endforeach
                    </select>
                    <p class="error">{{$errors->first('category_id')}}</p>
                </div>
               
                <div class="mb-3">
                    <label for="instock">Instock</label>
                    <input class="" type="checkbox" name="instock" id="" {{$product->instock == 1 ? 'checked':''}}>
                </div>
                <input type="file" id="cropped-image-file" style="display: none;" name="image" accept=".jpg, .jpeg, .png">
            </form>
            <input type="file" name="image" id="upload-image" style="display: none" accept=".jpg, .jpeg, .png">
            <button id="btn_add" class="btn btn-primary" style="float:right;">Update</button>
        </div>

        <br>

        @if (count($images)>0)
            <div class="card gallary" style="padding:20px;">
                @if (session('imageMsg'))
                    <div class="alert alert-success">
                        {{session('imageMsg')}}
                    </div>
                @endif
                <h5>Image Gallery</h5>
                <div class="image-box">
                    @foreach ($images as $image)
                        <div>
                            <img src="https://www.riniforyou.com/storage/app/public/{{$image->image_url}}" id="" />
                            <a class="btn btn-secondary" href="#" data-toggle="modal" 
                                data-target="#delete-modal-{{$image->id}}"><i class="fas fa-trash"></i></a>
                        </div>
                    @endforeach
                </div>
            </div>

            @foreach ($images as $image)
                <div class="modal fade" id="delete-modal-{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="">Delete Image</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="alert alert-warning">
                                Do you really want to delete this image?
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <form action="{{route('admin.products.images.delete',[$product->id,$image->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="status" value="1" value="0">
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <br>
        <div class="card gallary" style="padding:20px;">
            <h5>Add Image</h5>

            <div id="progress-bar" style="display: none">
                <div id="progress">

                </div>
            </div>

            <div id="image-box" class="image-box">

            </div>
            <input type="file" style="display: none;" id="gallery-input" accept=".jpg, .jpeg, .png" multiple>
            <span class="btn image-picker" id="gallery-picker">
                <i class="fas fa-plus"></i>
            </span>

            <form id="image_form" action="" method="post">
                @csrf
            </form>

            <button id="btn_upload_images" class="btn btn-primary" style="display: none">Upload</button>
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

    <script>
        let selected_files;
        let csrf_form = $('#csrf_form');
        let _token = csrf_form[0].children[0].value;
        $(document).ready(()=>{

            $('#gallery-picker').click(()=>{
                $('#gallery-input').click();
            })

            $('#gallery-input').change(()=>{
                selected_files = []
				var files=$('#gallery-input').prop('files');
                $('#btn_upload_images').show();
                setImage(files);
               
			})

            $('#btn_upload_images').click(()=>{
               
                selected_files = selected_files.filter((file)=>{
                    return file != null;
                })

                $('.image-unselect').each((index,element)=>{
                    $(element).hide();
                })

                if(selected_files.length>0){
                    $('#progress-bar').show();
                    let progress = 0 ;
                    for(var i = 0; i<selected_files.length;i++){
                        let file = selected_files[i];
                        
                        let formData = new FormData();
                        formData.append('image', file);
                        formData.append('_token',_token);
                        var ajax=new XMLHttpRequest();
                        ajax.onload =function(){
                            progress++;
                            let temp = progress*100;
                            temp = temp/selected_files.length;
                            console.log('progress',temp);
                            $('#progress').attr('style',`width:${temp}%`);
                            if(temp>=100){
                                window.location.href = "";
                            }

                        };
                        ajax.open("post",`{{asset("")}}api/products/{{$product->id}}/upload-image`,true);
                        ajax.setRequestHeader('Accept','application/json');
                        ajax.send(formData); 
                    }
                }
            })
        })

        function removeImage(index){
            $(`#selected-container-${index}`).hide();
            selected_files[index] = null;
        }

        function setImage(files){
            $('#image-box').html("");
            for(var i = 0; i<files.length; i++){
                var file = files[i];
                selected_files[i] = file;
                let reader = new FileReader();
                reader.index = i;
                reader.onload = function (e){
                    imageSrc=e.target.result;
                    $('#image-box').append(`
                        <div id="selected-container-${reader.index}">
                            <img src="${imageSrc}" id="selected-img-${reader.index}" />
                            <span onclick="removeImage(${reader.index})" id="selected-close-${reader.index}" class="btn btn-secondary image-unselect"><i class="fas fa-trash"></i></span>
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            }
        }

    </script>
@endsection