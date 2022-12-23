<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">{{__('lang.User')}}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ml-auto">
                <li class="nav-item px-2">
                    {{--                    <a class="nav-link active text-light " aria-current="page" href="#">Add New</a>--}}
                </li>


                <li class="px-3">
                    <button type="button" class="btn btn-outline-primary editRecord" data-bs-toggle="modal" data-bs-target="#editProfileModal">{{__('lang.Profile')}}</button>
                    <a href = "/logout"><button type="button" class="btn btn-outline-primary">{{__('lang.Logout')}}</button></a>

                </li>
            </ul>
        </div>
    </div>
</nav>



<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <input type="hidden" value="" id="id" name="id">
                    <div class="mb-3">
                        <label for="username" class="form-label">{{__('lang.Username')}}</label>
                        <input type="text" class="form-control" id="username" value="" name="username" aria-describedby="username">
                        <span class="text-danger error-text username_error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{__('lang.email')}}</label>

                        <input type="email" class="form-control" id="email" value="" name="email" aria-describedby="email">
                        <span class="text-danger error-text email_error"></span>
                    </div>
{{--                    <div class="mb-3">--}}
{{--                        <label for="password" class="form-label">Password</label>--}}

{{--                        <input type="password" class="form-control" id="password" value="" name="password" aria-describedby="password">--}}
{{--                        <span class="text-danger error-text password_error"></span>--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <label for="c_password" class="form-label">Confirm Password</label>--}}

{{--                        <input type="password" class="form-control" id="c_password" value="" name="c_password" aria-describedby="password">--}}
{{--                        <span class="text-danger error-text password_error"></span>--}}
{{--                    </div>--}}

                    <button type="submit" class="btn btn-primary close" data-dismiss="modal" id="update_form">{{__('lang.Update')}}</button>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>



<div class="d-inline-flex p-2 my-5 float-end">
<div class="input-group">
    <input type="search" class="form-control rounded searchbar" value="" placeholder="Search here...." aria-label="Search" aria-describedby="search-addon" />
    <button type="button"  class="btn btn-outline-primary me-2 searchBtn">{{__('lang.Search')}}</button>
    <a href="/user"><button type="button" class="btn btn-primary me-2">{{__('lang.Reset')}}</button></a>
</div>
</div>






<table class="table table-striped table-bordered" id="myTable">

    <div id="success_message"></div>
    <thead>

    <tr>
        <th scope="col">{{__('lang.Sno')}}</th>
        <th scope="col">{{__('lang.Book-Title')}}</th>
        <th scope="col">{{__('lang.AuthorName')}}</th>
    </tr>
    </thead>
    <tbody id="tableBody">
    </tbody>

</table>


<script>
    $(document).ready(function (){
        $.ajax({
                type:"get",
                url:'/search',
                dataType:"JSON",
                success:function (response)
                {
                    console.log(response.users);
                    let i=1;
                    $.each(response.users, function (key,item){
                        $('tbody').append(`<tr>

                            <th scope="row">`+(i++)+`</th>
                            <td>`+item.title+`</td>
                            <td>`+item.AuthorName+`</td>
                        </tr>`)
                    })
                }
            });
            $(document).on('click','.searchBtn', function (e)
            {
                e.preventDefault();
                $('#tableBody').empty();
                let searchValue = $('.searchbar').val();
                $.ajax({
                    type:'GET',
                    url:'/search/'+searchValue,
                    dataType:"JSON",
                    success: function (response) {
                            console.log(response)
                        $.each(response.users, function (key, item){

                            $('tbody').append(`<tr>
                           <td>`+item.id+`</td>
                          <td>`+item.title+`</td>
                        <td>`+item.AuthorName+`</td>
                    </tr>`)
                        })
                    },
                })
            })

        $(document).on('click','.editRecord', function (e){

            e.preventDefault()



            $('#editProfileModal').modal('show');

                $.ajax({
                    type: 'GET',
                    url:'/editProfile',
                    success:function (response){
                       $('#id').val(response.student.id);
                       $('#username').val(response.student.username);
                       $('#email').val(response.student.email);
                       $('#password').val(response.student.password);
                    }


                })





        });
$(document).on('click','#update_form', function (e){

    e.preventDefault()
let data = {
        username: $('#username').val(),
        email:$('#email').val(),
        password:$('#password').val(),
}  ;
    console.log(data);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    $.ajax({
    type:'PUT',
    url:'/updateProfile',
    data:data,
    dataType:'JSON',
    success: function (response){
        if(response.status === 200){
            if(response.message === 'success')
            {
               window.location.replace('/user')

            }

        }
    }
    });






});





    });





















</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
