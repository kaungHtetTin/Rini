@extends('master')
@section('content')
<style>
    .search-form{
        width: 80%;
        margin: auto;
        background: #f89cab;
        border-radius: 15px;
        padding:5px;
        display: flex;
    }
    .search-form input{
        width: 85%;
        border-radius: 10px;
        padding: 5px;
        border: 1px solid #f89cab;
        outline: #f89cab69;
    }
    .search-form div{
        cursor: pointer;
        width: 15%;
        text-align: center;
        color: white;
        padding-top: 7px;
    }

    .voucher{
        padding:10px;
        margin: 5px;
        color:#333;
        text-align: left;
    }

    .voucher:hover{
        background: #f89cab31;
        color:#f89cab !important;
    }
</style>

<style>
table img{
    width: 30px;
    height:30px;
    border-radius: 5px;
    border: 1px solid #f89cab;
}
table tr td{
    padding:7px;
}

.minus{
    cursor: pointer;
    height:30px;
    width: 30px;
    border: 1px solid #f89cab;
    text-align: center;
    border-radius: 50%;
    color: #f89cab;
    padding-top:3px;
}
.plus{
    cursor: pointer;
    height:30px;
    width: 30px;
    border: 1px solid #f89cab;
    text-align: center;
    border-radius: 50%;
    color: #f89cab;
    padding-top:3px;
}

.buy {
    padding: 8px 35px;
    outline: none;
    border: none;
    color: #ffffff;
    background: #f89cab;
    margin-top: 15px;
    border: 1px solid #f89cab;
    text-transform: uppercase;
    border-radius: 5px;
    margin: 7px;
    cursor: pointer;
}

.buy:hover {
    padding: 8px 35px;
    outline: #f89cab;
    color: #f89cab;
    margin-top: 15px;
    text-transform: uppercase;
    border-radius: 5px;
    margin: 7px;
    background: white;
    cursor: pointer;
}
.total{
    border: 1px solid #f89cab;
    border-radius: 7px;
    background: #f89cab;
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
    border: 1px solid #777;
    padding:5px;
    text-align: center;
    cursor: pointer;
    color: #777;
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


    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                   Trade Now
                </h2>
            </div>
        
            @if ($status == 0 || $status == 1)
                <form id="form_search" class="search-form" action="" method="get">
                    <input type="text" placeholder="Enter your phone number" name="phone" value="">
                    <div id="btn_search"><i class="fas fa-search"></i></div>
                </form>
                @if ($status == 1)
                    <br><br>
                    <div class="alert alert-info text-center">
                        You need to collaborate with Rini to trade.<br>
                        Thank you.
                    </div>
                @endif
            @endif

            @if ($status == 2)
                <form id="csrf_form" action="" method="post">
                    @csrf
                </form>

                <div>
                    <section class="contact_section ">
                        <form action="#">
                            <span class="error" style="display:none" id="item_quantity_error">Define quantity for one item at lease.</span>
                            <table style="width:100%;margin-bottom:20px;s">
                                <thead>
                                    <th colspan="2">Item</th>
                                    <th class="text-center" colspan="3">Quantity</th>
                                    <th class="text-center">Trade Price</th>
                                    <th class="text-center">Total</th>
                                </thead>
                                <tbody id="product_container">
                                    
                                </tbody>
                            </table>

                            <div>
                                <span class="error" style="display:none" id="input_phone_error">Enter your phone</span>
                                <input id="input_phone" type="text" placeholder="Phone" value="{{$customer->phone}}" disabled />
                            </div>
                            <div>
                                <span class="error" style="display:none" id="input_name_error">Enter your name</span>
                                <input id="input_name" type="text" placeholder="Name" value="{{$customer->name}}" disabled/>
                            </div>
                            <div>
                                <span class="error" style="display:none" id="input_address_error">Enter your address</span>
                                <input id="input_address" type="text" placeholder="Address" value="{{$customer->address}}" />
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
                        <div class="btn buy" id="btn_buy_now">Order Now</div>
                        <br>
                    </section>
                </div>
            @endif
            
            <br><br>
        </div>
    </section>

  <!-- end shop section -->
  <br><br>

  <script>
    $(document).ready(()=>{
        $('#btn_search').click(()=>{
            $('#form_search').submit();
        })
    })
  </script>

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
                    let phone = $('#input_phone').val();
                    let name = $('#input_name').val();
                    window.localStorage.setItem('rini_user_phone',phone);
                    window.localStorage.setItem('rini_username',name);
                    window.localStorage.setItem('rini_cart',"[]");
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
                let price = product.trade_price;
                let quantity = product.quantity;
                let final_price = price;
                $('#product_container').append(`
                    <tr>
                        <td><img src="https://www.riniforyou.com/storage/app/public/${product.image_url}" alt=""></td>
                        <td>${product.title}</td>
                        <td width="30px">
                            <div class="minus" onclick="decrease(${product.id})"><i class="fas fa-minus"></i></div>
                        </td>
                        <td align="center" id="quantity_${product.id}">${product.quantity}</td>
                        <td width="30px"> <div class="plus" onclick="increase(${product.id})"><i class="fas fa-plus"></i></div> </td>
                        <td class="text-center">${product.trade_price}</td>
                        <td class="text-center" id="total_${product.id}"">${quantity*final_price}</td>
                    </tr> 
                `);
            })

            $('#product_container').append(`
                <tr class="total">
                    <td colspan="6"><strong>Total</strong></td>
                    <td class='text-center'><span id="total_amount"></span></td>
                </tr>
            `)
            calculateTotalAmount();
        }

        function increase(id){
            let product = products.find(p => p.id == id);
            let price = product.trade_price;
            product.quantity = product.quantity + 1;
            let final_price = price;
        
            $(`#quantity_${product.id}`).html(product.quantity);
            $(`#total_${product.id}`).html(product.quantity * final_price);
            calculateTotalAmount();
        }

        function decrease(id){
            let product = products.find(p => p.id == id);
            let price = product.trade_price;
            if(product.quantity > 0){
                product.quantity = product.quantity - 1;

                let final_price = price;

                $(`#quantity_${product.id}`).html(product.quantity);
                $(`#total_${product.id}`).html(product.quantity * final_price);
                calculateTotalAmount();
            }
        }

        function calculateTotalAmount(){
            let total = 0;
            products.forEach(product => {
                let price = product.trade_price;
                let quantity = product.quantity;
                let final_price = price;

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
            formData.append('trade', 'trade');
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
                    window.location.href="{{route('vouchers')}}?phone="+phone;
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});
        }

    </script>

@endsection
