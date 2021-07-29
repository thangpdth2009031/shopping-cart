<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form Product</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}">
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js')}}"></script>
    <script src="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js')}}"></script>
</head>
<body>

<div class="container">
    <h2>Form Product</h2>
    <form action="" class="needs-validation" method="post" novalidate>
        @csrf
        <div class="form-group">
            <label for="uname">Name:</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
            <div class="invalid-feedback">Please enter your name.</div>
        </div>
        <div class="form-group">
            <label for="pwd">Thumbnail:</label>
            <input type="text" class="form-control" placeholder="Enter thumbnail" name="thumbnail" required>
            <div class="invalid-feedback">Please enter photo link.</div>
        </div>
        <div class="form-group">
            <label for="pwd">Price:</label>
            <input type="text" class="form-control" placeholder="Enter price" name="price" required>
            <div class="invalid-feedback">Please enter price.</div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    // Disable form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Get the forms we want to add validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

</body>
</html>
