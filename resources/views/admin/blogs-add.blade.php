@extends('admin.master')
@section('content')
    <style>
        .image-upload-wrap {
            border: 1px solid #d1d3e2;
            position: relative;
            border-radius: 7px;
            background-color: #fff;
            text-align: center;
            cursor: pointer;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #fff;
            border: 1px solid #d1d3e2;
        }

        .image-title-wrap {
            padding: 0 15px 15px 15px;
            color: #847577;
        }
        .drag-text {
            text-align: center;
            padding: 30px;
        }

        .drag-text h4 {
            font-size:16px;
            font-weight: 500;
            text-transform: none;
            color: #333;
            font-family: 'Roboto', sans-serif;
            margin-bottom:5px;
            margin-top: 0;
        }
        .drag-text p{
            font-size:12px;
            font-weight: 400;
            text-transform: none;
            color: #686f7a;
            font-family: 'Roboto', sans-serif;
            line-height:12px;
        }
        .drag-text i{
            font-size:24px;
            text-transform: none;
            color: #a1a1a1;
            margin-bottom:10px;
        }
        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }
        #toolbar button {
			background-color: transparent;
			color: #333;
			border: none;
			padding: 10px;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			width: 40px;
			height: 40px;
			transition: color 0.3s;
		}

		#toolbar {
			margin-bottom: 10px;
			display: flex;
			gap: 10px;
		}


		#toolbar button:hover {
			color: #475692;
		}

		#toolbar button.active {
			color: #475692;
		}


		pre code {
			background-color: #ecffeb;
			color: #3a3a3a;
			font-family: 'Courier New', Courier, monospace;
			padding: 3px;
			border-radius: 2px;
			display: block;
			font-size: 12px;
			white-space: pre-wrap;
		}

		.field div ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}
		.input_error{
			color:red;
			padding:5px;
			display: none;
		}

		.description_preview ul{
			list-style-type: disc;
			margin-inline-start: 20px;
		}

        .form-des {
            display: block;
            width: 100%;
            min-height: 250px;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6e707e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-des:focus {
            color: #6e707e;
            background-color: #fff;
            border-color: #bac8f3;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

    </style>
    <div class="container-fluid">
        <form id="csrf_form" action="" method="post">
            @csrf
        </form>

         @if (session('msg'))
            <div class="alert alert-success">
                {{session('msg')}}
            </div>
        @endif

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Blog</h1>
            
        </div>

        <div class="card" style="padding: 20px;">
            <form action="{{route('admin.blogs.store')}}" method="post" enctype="multipart/form-data" id="submit_form">
                @csrf
                <div class="mb-3">
                    <span>Blog Title</span>
                    <input class="form-control" type="text" name="title" id="">
                    <p class="error">{{$errors->first('title')}}</p>
                </div>
                <div class="mb-3">
                    <span>Short Description</span>
                    <textarea  class="form-control" name="short_description" id="" cols="30" rows="3"></textarea>
                    <p class="error">{{$errors->first('short_description')}}</p>
                </div>
                <div class="mb-3">
                    <span>Blog Cover Photo (Optional)</span>
                    <div class="image-upload-wrap" id="cover_photo_container">
                        <input class="file-upload-input" name="cover_image" id="input_cover_photo" type="file" accept="image/*">
                        <div class="drag-text">
                            <i id="upload_icon" class="fas fa-cloud-upload-alt"></i>
                            <img id="upload_cover_image"  alt="" style="width: 250px;border-radius:3px;display:none">
                            <h4>Select an image to upload</h4>
                        </div>
                    </div>		
                </div>
                <div class="mb-3">
                    <span>Description</span>
                    <div class="course_des_bg">
                        <div id="toolbar">
                            <button type="button" data-command="bold" id="boldBtn"><i class="fas fa-bold"></i></button>
                            <button type="button" data-command="italic" id="italicBtn"><i class="fas fa-italic"></i></button>
                            <button type="button" data-command="insertUnorderedList" id="listBtn"><i class="fas fa-list-ul"></i></button>
                            <button type="button" id="codeBtn" style="display: none"><i class="fas fa-code"></i></button>
                            <button type="button" id="imageBtn"><i class="fas fa-image"></i></button>
                        </div>
                        <div class="">
                            <div class="field">
                                <div name="description" class="form-des" id="editor" contenteditable="true"></div>
                            </div>
                        </div>
                        <input type="hidden" name="description" id="input_des">
                    </div>
                </div>

                <input id="editor_input_file" type="file" accept="image/*" style="display: none">
                
            </form>
            <button id="btn_add" class="btn btn-primary">Add Now</button>
        </div>

    </div>

    <script src="{{asset('js/editor.js')}}"></script>
    <script>
        const imageShimmer = "{{asset('images/img-1.jpg')}}";

        let csrf_form = $('#csrf_form');
        let _token = csrf_form[0].children[0].value;

        $(document).ready(()=>{

            $('#cover_photo_container').click(()=>{
                $('#input_cover_photo').click();
            })
        

            $('#input_cover_photo').change(()=>{
                let files = $('#input_cover_photo').prop('files');
                let file = files[0];
               
                let reader = new FileReader();
                reader.onload = function (e){
                    imageSrc=e.target.result;
                    $('#upload_cover_image').attr('src', imageSrc);
                    $('#upload_cover_image').show();
                    $('#upload_icon').hide();
                }

                reader.readAsDataURL(file);
            })

            $('#imageBtn').click(()=>{
				$('#editor_input_file').click();
			})

            $('#editor_input_file').change(()=>{
				var files=$('#editor_input_file').prop('files');
				var file=files[0];
				uploadPhoto(file);
			})

            $('#btn_add').click(()=>{
                let description = $('#editor').html();
                $('#input_des').val(description);
                $('#submit_form').submit();
            })

        })

        function uploadPhoto(file){
			var image_id = Date.now();
			let imageView = `
				<br>
				<img style="width:75%;border-radius:5px;height:auto;margin:auto" id="${image_id}" src = "${imageShimmer}" />
				<br>
			`;
			$('#editor').append(imageView);

			let formData = new FormData();
			formData.append('image', file);
            formData.append('_token',_token);

			$.ajax({
				url: `{{asset("")}}api/blogs/upload-image`,
				type: 'POST',
				data: formData,
				contentType: false, // Important
				processData: false, // Important
				headers: {
					'Accept': 'application/json'
				},
				success: function(response) {
					console.log(response);
					$('#'+image_id).attr('src',"http://localhost/rini/storage/app/public/"+response);
				},
				error: function(xhr, status, error) {
					console.log('Error:', xhr.status, error);
					 
				}
			});
			
		}

    </script>
@endsection