<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">{{__('lang.Admin')}}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ml-auto">
                <li class="nav-item px-2">
                    <a class="nav-link text-light " href="admin">{{__('lang.Home')}}</a>
                </li>



                <li class="px-3">

                    <a href = "logout"><button type="button" class="btn btn-primary">{{__('lang.Logout')}}</button></a>
                </li>

            </ul>
        </div>
    </div>
</nav>


{{--<div class="d-flex justify-content-end my-3  ">--}}
{{--    <a href="/addBooks"><button type="button" class="btn btn-outline-white">AddBooks</button></a>--}}
{{--</div>--}}
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="EditBooksModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Books</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class="container my-4">
{{--                    <form action="/updateBook" method="POST">--}}
                        @csrf
                        <input type="hidden" value="" id="id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Book Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="" aria-describedby="title">
                            <span class="text-danger error-text title_error"></span>
                        </div>

                        <div class="mb-3">
                            <label for="AuthorName" class="form-label">AuthorName</label>
                            <input type="text" class="form-control" id="AuthorName" name="AuthorName" value="" aria-describedby="AuthorName">
                            <span class="text-danger error-text AuthorName_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="Cost" class="form-label">Cost</label>
                            <input type="number" class="form-control" id="Cost" name="Cost" value="" aria-describedby="Cost">
                            <span class="text-danger error-text Cost_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="" aria-describedby="quantity">
                            <span class="text-danger error-text quantity_error"></span>
                        </div>


                        <button type="submit" class="btn btn-primary  update_book">Update</button>
{{--                    </form>--}}
                </div>
            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                <button type="button" class="btn btn-primary">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>



<div class="container d-flex justify-content-center my-4">
<table class="table table-striped table-bordered">
<div id="success_message"></div>
    <thead>

    <tr>
        <th scope="col">{{__('lang.Book-Id')}}</th>
        <th scope="col">{{__('lang.Book-Title')}}</th>
        <th scope="col">Cost{{__('lang.Cost')}}</th>
        <th scope="col">Quantity{{__('lang.Quantity')}}</th>
        <th scope="col"><a href="/addBooks"><button type="button" class="btn btn-secondary">{{__('lang.AddBooks')}}</button></a></th>
    </tr>
    </thead>
    <tbody>


    </tbody>

</table>
</div>


<script>

    $(document).ready(function (){
        fetchdata();
        function fetchdata()
        {
            $.ajax({
                type: 'GET',
                url: '/showBook',
                dataType: 'json',
                success: function (response) {
                    let i = 1;
                    $.each(response.users, function (key, item){
                        $('tbody').append(`<tr>

                            <th scope="row">`+(i++)+`</th>
                          <td>`+item.title+`</td>
                        <td>`+item.Cost+`</td>
                        <td>`+item.quantity+`</td>
                        <td>
                            <a href="#"><button type="button" class="btn btn-danger editBooksbtn" value="`+item.id+`" data-bs-toggle="modal" data-bs-target="#EditBooksModal">{{__("lang.edit")}}</button></a>
                            <button class="btn btn-primary deleteBook" value="`+item.id+`" type="button">{{__("lang.Delete")}}</button>
                        </td>
                    </tr>`)
                    })
                },

            })
        }

        $(document).on('click','.editBooksbtn',function(e)
        {

            e.preventDefault();
            let booksId = $(this).val();
            console.log(booksId);
            $('#EditBooksModal').modal('show');
                $.ajax({
                    type:"GET",
                    url:"/editBook/"+booksId,
                    // data:"data",
                    dataType:"JSON",
                    success:function (response){
                        // console.log(response)

                        if(response.status ===404 ){
                            $('#success_message').html("")
                            $('#success_message').addClass('alert alert-danger')
                            $('#success_message').text(response.message)
                        }else{
                            $('#title').val(response.data.title);
                            $('#AuthorName').val(response.data.AuthorName);
                            $('#Cost').val(response.data.Cost);
                            $('#quantity').val(response.data.quantity);
                            $('#id').val(booksId);
                        }


                    }
                })


        });


        $(document).on('click','.update_book',function(e)
        {
            e.preventDefault();
            // var bookId = $('#id').val();
            var data ={
                  'id' :$('#id').val(),
                'title':$('#title').val(),
                'AuthorName':$('#AuthorName').val(),
                'Cost':$('#Cost').val(),
                'quantity':$('#quantity').val(),
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax
            ({
                type:'put',
                url:'/updateBook',
                data:data,
                dataType:'JSON',
                success:function(response){
                    // console.log(response)
                    if(response.status === 400){
                        $.each(response.error,function (prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        });
                    }else if(response.status === 404){
                        $('#success_message').html("")
                        $('#success_message').addClass('alert alert-danger')
                        $('#success_message').text(response.message)
                    }else{
                        if(response.status === 200){
                            $('#EditBooksModal').modal('hide');
                            window.location.replace('/showBooks');
                        }



                    }
                },
            });



        });

            $(document).on('click','.deleteBook',function (e){

                e.preventDefault();
                if(confirm('Are you sure you want to delete')){

                   let bookId = $(this).val();

                   $.ajax({
                      type:"GET",
                       url:'/deleteBook/'+bookId,
                       success:function (response){
                           $(this).parent().parent().remove();
                           $('#output').text(response.result);
                           window.location.replace('/showBooks');
                       },
                       error:function(err){
                          console.log(err.responseText);
                       }


                   });


                }
            });





    });



</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>




</body>
</html>
