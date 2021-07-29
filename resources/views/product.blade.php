<!DOCTYPE html>
<html lang="en">
<head>
    <title>List Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')}}">
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js')}}"></script>
    <script src="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}}"></script>
</head>
<body>

<div>
    <table class="table table-dark">
        <thead>
        <tr>
            <th>Id</th>
            <th>Thumbnail</th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $products)
            <tr>
                <td>{{$products->id}}</td>
                <td><img src="{{$products->thumbnail}}" style="width: 100px"></td>
                <td>{{$products->name}}</td>
                <td style="color: red">€{{$products->price}}</td>
                <th>
                    <a href="/shopping/add?productId={{$products->id}}&productQuantity=1">
                        <button class="btn btn-primary">Add to cart  <i class="fa fa-shopping-cart"></i></button>
                    </a>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
