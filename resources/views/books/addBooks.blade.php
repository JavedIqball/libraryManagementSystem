<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ml-auto">
                <li class="nav-item px-2">
                    <a class="nav-link text-light " href="/admin">Home</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link text-light " href="#">Link</a>
                </li>
                <li class="nav-item px-2 ">
                    <a class="nav-link text-light " href="#">About</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link text-light " href="#">Contact</a>
                </li>
                <li class="px-3">

                    <a href = "/logout"><button type="button" class="btn btn-primary">Logout</button></a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<div class="container">
{{--<form action="/addBook" method="POST">--}}
@csrf
    <div class="mb-3">
        <label for="title" class="form-label">Book Title</label>
        <input type="text" class="form-control" id="title" name="title" value="" aria-describedby="title">
    </div>

      <div class="mb-3">
        <label for="AuthorName" class="form-label">AuthorName</label>
        <input type="text" class="form-control" id="AuthorName" name="AuthorName" value="" aria-describedby="AuthorName">
    </div>
     <div class="mb-3">
        <label for="Cost" class="form-label">Cost</label>
        <input type="number" class="form-control" id="Cost" name="Cost" value="" aria-describedby="Cost">
    </div>
     <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="" aria-describedby="quantity">
    </div>


    <button type="submit" id="storeBook" class="btn btn-primary">Add</button>
{{--</form>--}}
</div>

<script>

    $(document).ready(function (){

        $('#storeBook').on('click',function (){
            let data = {
                'title': $('#title').val(),
                'AuthorName':$('#AuthorName').val(),
                'Cost':$('#Cost').val(),
                'quantity':$('#quantity').val(),
            }
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({

                url:'/addBook',
                type:'post',
                data:data,
                dataType:'JSON',
                beforeSend: function(){

                },
                success: function(response){
                    if(response.status === 200){
                        window.location ='addBooks';
                        if(window.location){
                            alert('books submitted successfully');
                        }
                    }

                }




            });



        });



    })




</script>







<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
