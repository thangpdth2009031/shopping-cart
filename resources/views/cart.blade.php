<!DOCTYPE html>
<html lang="en">
<head>
    <title>List Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .w3-input {
            outline: none;
        }
        .w3-dark {
            background: #454d55;
            color: white;
        }
    </style>
</head>
<body>

<div>

    <table class="table table-dark">

        <thead>
        @if(session('message'))
            <div class="w3-panel w3-green w3-display-container">
  <span onclick="this.parentElement.style.display='none'"
        class="w3-button w3-large w3-display-topright">&times;</span>
                <h3>Success!</h3>
                <p>{{session('message')}}</p>
            </div>
        @endif
        @if(session('remove'))
            <div class="w3-panel w3-green w3-display-container">
                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                <h3>Success!</h3>
                <p>{{session('remove')}}</p>
            </div>
        @endif
        <tr>

            <th>Id</th>
            <th>Thumbnail</th>
            <th style="width: 400px">Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalPrice = 0;
        ?>
        @foreach($shoppingCart as $products)
            <?php
            if (!empty($products)) {
                $totalPrice += $products->price * $products->quantity;
            }
            ?>
            <form action="{{route('thang')}}" method="get">
                <input type="hidden" name="cartAction" value="update">
                <input type="hidden" name="productId" value="{{$products->id}}">
                <tr>
                    <td>{{$products->id}}</td>
                    <td><img src="{{$products->thumbnail}}" style="width: 100px"></td>
                    <td>{{$products->name}}</td>
                    <td style="color: red">€{{$products->price}}</td>
                    <td><input style="outline: none" type="number" min="1" name="productQuantity" value="{{$products->quantity}}"></td>
                    <td>{{$products->quantity * $products->price}}</td>
                    <th>
                        <button class="btn btn-primary m-2" style="font-size: 15px"><i class="fas fa-edit"></i> Update
                        </button>
                        <a class="btn btn-danger m-2" href="/shopping/remove?productId={{$products->id}}"
                           onclick="return confirm('Ban co muon xoa?')">
                            <i class="fas fa-trash-alt"></i> Remove
                        </a>
                    </th>
                </tr>
            </form>
        @endforeach
        </tbody>
    </table>
    <div class="w3-container row">
        <div class="col-7">
            <h3>Total Price: <span  style="color: red">€{{$totalPrice}}</span></h3>
        </div>
        <div class="col-5">
            <div class="w3-card-4">
                <div class="w3-container w3-dark">
                    <h2>Form Order</h2>
                </div>

                <form class="w3-container" method="post" action="/shopping/save">
                    @csrf
                    <div class="m-0 mt-3">
                        <input class="w3-input" type="text" name="shipName">
                        <label>Ship Name</label>
                    </div>
                    <div class="m-0">
                        <input class="w3-input" type="text" name="shipAddress">
                        <label>Address</label>
                    </div>
                    <div class="m-0">
                        <input class="w3-input" type="text" name="shipPhone">
                        <label>Phone</label>
                    </div>
                    <div class="mb-3">
                        <input class="w3-input" type="text" name="note">
                        <label>Note</label>
                    </div>
                    <div class="row ml-1">
                        <button class="btn btn-dark mb-3 mr-3">Submit Order</button>
                        <div id="paypal-button"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Button.render({
        // Configure environment
        env: 'sandbox',
        client: {
            sandbox: 'AS43Ou7Utllt7y6_2i-wWBXmt-QLJhXpzDY8MKja1EnHhIrvCi12XIHRef-RY2LsK6u5i51mgZuoAFHN',
            production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: '30.11',
                        currency: 'USD',
                        details: {
                            subtotal: '30.00',
                            tax: '0.07',
                            shipping: '0.03',
                            handling_fee: '1.00',
                            shipping_discount: '-1.00',
                            insurance: '0.01'
                        }
                    },
                    description: 'The payment transaction description.',
                    custom: '90048630024435',
                    //invoice_number: '12345', Insert a unique invoice number
                    payment_options: {
                        allowed_payment_method: 'INSTANT_FUNDING_SOURCE'
                    },
                    soft_descriptor: 'ECHI5786786',
                    item_list: {
                        items: [
                            {
                                name: 'hat',
                                description: 'Brown hat.',
                                quantity: '5',
                                price: '3',
                                tax: '0.01',
                                sku: '1',
                                currency: 'USD'
                            },
                            {
                                name: 'handbag',
                                description: 'Black handbag.',
                                quantity: '1',
                                price: '15',
                                tax: '0.02',
                                sku: 'product34',
                                currency: 'USD'
                            }],
                        shipping_address: {
                            recipient_name: 'Brian Robinson',
                            line1: '4th Floor',
                            line2: 'Unit #34',
                            city: 'San Jose',
                            country_code: 'US',
                            postal_code: '95131',
                            phone: '011862212345678',
                            state: 'CA'
                        }
                    }
                }],
                note_to_payer: 'Contact us for any questions on your order.'
            });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                // Show a confirmation message to the buyer
                window.alert('Thank you for your purchase!');
            });
        }
    }, '#paypal-button');

</script>
</body>
</html>
