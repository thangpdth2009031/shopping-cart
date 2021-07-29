<!DOCTYPE html>
<html lang="en">
<head>
    <title>List Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('https://www.w3schools.com/w3css/4/w3.css')}}">
    <link rel="stylesheet" href="{{url('https://pro.fontawesome.com/releases/v5.10.0/css/all.css')}}"/>
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js')}}"></script>
    <script src="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}}"></script>
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
            <th>Name</th>
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
                    <td><input type="number" min="1" name="productQuantity" value="{{$products->quantity}}"></td>
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
    <div>Total Price: {{$totalPrice}}</div>
</div>

</body>
</html>
