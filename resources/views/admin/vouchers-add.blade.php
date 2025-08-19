@extends('admin.master')
@section('content')

    <style>
        table img{
            width: 30px;
            height:30px;
            border-radius: 5px;
            border: 1px solid #e83e8c;
        }
        table tr td{
            padding:7px;
        }

        .minus{
            cursor: pointer;
            height:30px;
            width: 30px;
            border: 1px solid #e83e8c;
            text-align: center;
            border-radius: 50%;
            color: #e83e8c;
            padding-top:3px;
        }
        .plus{
            cursor: pointer;
            height:30px;
            width: 30px;
            border: 1px solid #e83e8c;
            text-align: center;
            border-radius: 50%;
            color: #e83e8c;
            padding-top:3px;
        }

        .buy {
            padding: 8px 35px;
            outline: none;
            border: none;
            color: #ffffff;
            background: #e83e8c;
            margin-top: 15px;
            border: 1px solid #e83e8c;
            text-transform: uppercase;
            border-radius: 5px;
            margin: 7px;
            cursor: pointer;
        }

        .buy:hover {
            padding: 8px 35px;
            outline: #e83e8c;
            color: #e83e8c;
            margin-top: 15px;
            text-transform: uppercase;
            border-radius: 5px;
            margin: 7px;
            background: white;
            cursor: pointer;
        }
        .total{
            border: 1px solid #e83e8c;
            border-radius: 7px;
            background: #e83e8c;
            color: white;
        }

        #total_amount{
            font-weight: bold;
        }

        .error{
            color: red;
            font-size: 14px;
        }

        .payment{
            border: 1px solid #d1d3e2;
            padding:5px;
            text-align: center;
            cursor: pointer;
            color: #777;
            background: white;
            border-radius: 0.35rem;
        }

        #add_image_icon{
            margin: 40px;
        }

        #add_image_icon i{
            font-size: 40px;
        }


        .payment:hover{
            color:#333;
        }

    </style>

    @php
        foreach ($products as $product) {
            # code...
            $product->prices;
        }
    @endphp

    <form id="csrf_form" action="" method="post">
        @csrf
    </form>

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add New Order</h1>
        </div>

         <section class="contact_section ">
            <form action="#">
                <span class="error" style="display:none" id="item_quantity_error">Define quantity for one item at lease.</span>
                <table style="width:100%;margin-bottom:20px;s">
                    <thead>
                        <th colspan="2">Item</th>
                        <th colspan="3">Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </thead>
                    <tbody id="product_container">
                        
                    </tbody>
                </table>

                <div>
                    <span class="error" style="display:none" id="input_phone_error">Enter your phone</span>
                    <input class="form-control mb-3" id="input_phone" type="text" placeholder="Phone" />
                </div>
                <div>
                    <span class="error" style="display:none" id="input_name_error">Enter your name</span>
                    <input class="form-control mb-3" id="input_name" type="text" placeholder="Name"/>
                </div>
                <div>
                    <span class="error" style="display:none" id="input_address_error">Enter your address</span>
                    <input class="form-control mb-3" id="input_address" type="text" placeholder="Address" />
                </div>
                <input id="input_image" type="file" name="image" id="" style="display: none;" accept=".jpg, .jpeg, .png">
                <span class="error" style="display:none" id="input_image_error">Please Select the payment screenshot for the order.</span>
                <div class="payment" id="add_image">
                    <div id="add_image_icon">
                        <i class="fas fa-image"></i> <br>
                        <div class="info">Add Payment Screenshot</div>
                    </div>
                    <img id="imageView" src="" alt="" style="width: 150px;">
                </div>
            </form>
            <br>
            <div class="btn btn-primary" id="btn_buy_now">Add Now</div>
            <br>
        </section>

    <script>
        let products = @json($products);

        products.forEach((p)=>{
            p.quantity = 0;
        })
    
        let csrf_form = $('#csrf_form');
        let _token = csrf_form[0].children[0].value;

        $(document).ready(()=>{
            $('#btn_buy_now').click(()=>{
                if(validate()){
                    orderNow();
                }
            });

            $('#input_name').on('input',()=>{
                $('#input_name_error').hide();
            })

            $('#input_phone').on('input',()=>{
                $('#input_phone_error').hide();
            })

            $('#input_address').on('input',()=>{
                $('#input_address_error').hide();
            })

            $('#add_image').click(()=>{
                $('#input_image').click();
            })

            $('#input_image').change(()=>{
                var files=$('#input_image').prop('files');
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (e)=>{
                    let src = e.target.result;
                    $('#imageView').attr('src',src);
                    $('#add_image_icon').hide();
                    $('#input_image_error').hide();
                }

                reader.readAsDataURL(file);
            })

            setProduct(products);
        })

        function setProduct(products){
            $('#product_container').html("")
            products.map((product)=>{
                let quantity = product.quantity;
                if(product.prices.length>0){
                    let selected_price = selectPrice(product);
                    $('#product_container').append(`
                        <tr>
                            <td><img src="https://www.riniforyou.com/storage/app/public/${product.image_url}" alt=""></td>
                            <td>${product.title}</td>
                            <td width="30px">
                                <div class="minus" onclick="decrease(${product.id})"><i class="fas fa-minus"></i></div>
                            </td>
                            <td align="center" id="quantity_${product.id}">${product.quantity}</td>
                            <td width="30px"> <div class="plus" onclick="increase(${product.id})"><i class="fas fa-plus"></i></div> </td>
                            <td id="price_${product.id}">${selected_price}</td>
                            <td id="total_${product.id}"">${quantity*selected_price}</td>
                        </tr> 
                    `);
                }
            })

            $('#product_container').append(`
                <tr class="total">
                    <td colspan="6"><strong>Total</strong></td>
                    <td><span id="total_amount"></span></td>
                </tr>
            `)
            calculateTotalAmount();
        }

        function increase(id){
            let product = products.find(p => p.id == id);
            product.quantity = product.quantity + 1;

            let final_price = selectPrice(product);
        
            $(`#price_${product.id}`).html(final_price);
            $(`#quantity_${product.id}`).html(product.quantity);
            $(`#total_${product.id}`).html(product.quantity * final_price);
            calculateTotalAmount();
        }

        function decrease(id){
            let product = products.find(p => p.id == id);
            let price = product.price;
            if(product.quantity > 0){
                product.quantity = product.quantity - 1;

                let final_price = selectPrice(product);

                $(`#price_${product.id}`).html(final_price);
                $(`#quantity_${product.id}`).html(product.quantity);
                $(`#total_${product.id}`).html(product.quantity * final_price);
                calculateTotalAmount();
            }
        }

        function selectPrice(product){

            let quantity = product.quantity;
            
            let prices = product.prices
            if(prices.length==0) return 0;
            var index = prices.findIndex((price)=>{
                return price.quantity>quantity;
            });

            if(index == -1){
                return prices[prices.length-1].price;
            }

            if(index>0) index--;
            return (prices[index].price);
           
        }

        function calculateTotalAmount(){
            let total = 0;
            products.forEach(product => {

                let quantity = product.quantity;
             
                let final_price = selectPrice(product);

                total += product.quantity* final_price;
            });
            $('#total_amount').html(total +' ks');
            return total;
        }

        function validate(){
            let validate = true;
            if(products.length<0){
                validate = false;
            }

            let total_amount = calculateTotalAmount();
            if(total_amount>0){
                $('#item_quantity_error').hide();
            }else{
                $('#item_quantity_error').show();
                validate = false;
            }

            let name = $('#input_name').val();
            if(!name){
                $('#input_name_error').show();
                validate = false;
            }else{
                $('#input_name_error').hide()
            }

            let phone = $('#input_phone').val();
            if(!phone){
                $('#input_phone_error').show();
                validate = false;
            }else{
                $('#input_phone_error').hide()
            }

            let address = $('#input_address').val();
            if(!address){
                $('#input_address_error').show();
                validate = false;
            }else{
                $('#input_address_error').hide();
            }

            var files=$('#input_image').prop('files');
            if(files.length == 0){
                $('#input_image_error').show();
                validate = false;
            }else{
                $('#input_image_error').hide();
            }

            return validate;
        }

        function orderNow(){
            let name = $('#input_name').val();
            let phone = $('#input_phone').val();
            let address = $('#input_address').val();
            let items = JSON.stringify(products);

            let formData = new FormData();
            formData.append('_token',_token);
            formData.append('name',name);
            formData.append('phone',phone);
            formData.append('address',address);
            formData.append('items', items);
            let files=$('#input_image').prop('files');
            let file = files[0];
            formData.append('image', file);

			$.ajax({
				url: `{{asset("")}}api/vouchers`, // Replace with your API endpoint
				type: 'POST', // or 'GET' depending on your request
                data: formData,
                contentType: false, // Important
				processData: false, // Important
				success: function(response) {
                    window.location.href="{{route('admin.vouchers.new-orders')}}";
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
        }

    </script>


    </div>
@endsection