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
                    <a class="nav-link text-light " href="/admin">{{__('lang.Home')}}</a>
                </li>


                <li class="px-3">
                    <a href = "/logout"><button type="button" class="btn btn-primary">{{__('lang.Logout')}}</button></a>
                </li>
            </ul>
        </div>
    </div>
</nav>






<!-- AssignBook Modal -->
<div class="modal fade" id="assignBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('lang.AssignBook')}}</h1>
                <a href="/show"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
            </div>
            <div class="container my-4">
{{--                <form action="/show" method="POST">--}}
                    @csrf
                    <div class="mb-3">

                        <input type="text" class="form-control" id="userId" name="userId" value="" aria-describedby="id">
                        <span class="text-danger error-text id_error"></span>
                    </div>

                <select class="form-select" id="myOption" name="myOption" aria-label="Default select example">
                    <option class="optionTitle" value="" selected>Book Title</option>

                </select>


                <button type="submit" class="btn btn-primary my-3 updateAssignBook"data-dismiss="modal" name="submit_change" id="assignbook">Assign</button>
            </div>

            <div class="modal-footer">
                <a href="/show"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></a>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit & update</h1>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
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
                        {{--            <input type="email" class="form-control" id="email" value="{{$data->email}}" name="email" aria-describedby="email">--}}
                        <input type="email" class="form-control" id="email" value="" name="email" aria-describedby="email">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="role1" name="role" value="admin" >
                        <label for="radio">
                            Admin{{__('lang.Admin')}} </label>
                        <input type="radio" id="role2" name="role" value="user">
                        <label for="radio">
                            User</label><br>
                        <span class="text-danger error-text role_error" ></span>
                    </div>
                    <input type="hidden" name="role" id ="role" value=""/>
                    <a href="/show"><button type="submit" class="btn btn-primary close" data-dismiss="modal" id="update_form">Update</button></a>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
{{--modal--}}
<div class="container d-flex justify-content-center my-4">
    <table class="table table-striped table-bordered">
        <div id="success_message"></div>
        <thead>
            <tr>
                <th scope="col">{{__('lang.Sno')}}</th>
                <th scope="col">{{__('lang.Username')}}</th>
                <th scope="col">{{__('lang.email')}}</th>
                <th scope="col">{{__('lang.Role')}}</th>
                <th scope="col">{{__('lang.AssignedBooks')}}</th>
                <th scope="col">{{__('lang.Date of issue')}}</th>
                <th scope="col">{{__('lang.edit')}}</th>
                <th scope="col">{{__('lang.Delete')}}</th>
                <th scope="col"><a href="/storeIndex"><button type="button" class="btn btn-secondary">{{__('lang.AddUsers')}}</button></a></th>
            </tr>
        </thead>
        <tbody id="user-table">
        </tbody>
    </table>
</div>

<script>

    // showUser ajax

    $(document).ready(function()
    {
        $.ajax
        ({
            type:'GET',
            url:"/showUser",
            success:function (data){
                // console.log(data);
               if(data.users.length >0){

                    for(let i=0;i<data.users.length;i++)
                    {

                        var books="";
                       let k=1;
                        for(let j=0;j<data.users[i].books.length;j++)
                        {

                            books = books + '(' + data.users[i].books[j]['title'] +'. '+ k++ + ')' +'    ';

                        }

                        console.log(data.users);

                            $('#user-table').append(`<tr>
                           <th scope="row">`+(i+1)+`</th>

                           <td>`+(data.users[i]['username'])+`</td>
                           <td>`+(data.users[i]['email'])+`</td>
                           <td>`+(data.users[i]['role'])+`</td>
                           <td>`+(books)+`</td>
                           <td>`+(data.users[i]['created_at']+`</td>
                           <td><a class="editRecord" href="#" data-id="`+(data.users[i]['id'])+`"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#editModal">{{__("lang.edit")}}</button></td>\
                                <td><a class="deleteRecord"  href="#" data-id="`+(data.users[i]['id'])+`"><button  class="btn btn-primary">{{__('lang.Delete')}}</button></td>\
                             <td><button id="assign" class="btn btn-danger" data-id="`+(data.users[i]['id'])+`" data-bs-toggle="modal" data-bs-target="#assignbook">{{__('lang.AssignBook')}}</button></td>\
`))}}
               else
               {
                   $('#user-table').append('<tr><td colspan="4">Data not found</td></tr>')
               }
            },
            error:function (err){
                console.log(err.responseText);
            }
        });



        $(document).on('click','#assign', function (e){


            var assignBookId = $(this).attr("data-id");
            console.log(assignBookId);

                $('#assignBook').modal('show');

                $.ajax({
                   type:"GET",
                    url:'/editassign',

                    success:function (response){
                       if(response.status === 200 ){
                               $('#userId').val(assignBookId);
                               $.each(response.users, function (key, value){
                                   $('.form-select').append(`
                                    <option class="optionTitle" value="`+value.title+`">`+value.title+`</option>
                                   `)
                               })
                       }
                    },
                });
        });




        $(document).on('click','#assignbook', function (e){

      e.preventDefault();
      let data ={
          usersid:$('#userId').val(),
          book: $('.form-select').val(),
      }

console.log(data);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          }
      });
            $.ajax({
               type:'post',
                url: '/assignBook',
                data:data,
                dataType: 'JSON',
                success: function (response) {
                   console.log(response)

                        if(response.status === 200)
                        {
                            window.location.replace('/show');
                        }
                    // $('#assignBook').modal('hide');

                },
            });
  });















        $(document).on('click','.editRecord', function (e){

           let userId = $(this).attr("data-id");
           // console.log(userId);
            $('#editModal').modal('show');
            $.ajax({
                type:'GET',
                url:'/edit/'+userId,
                success: function (response){
                    if(response.status === 404){
                        $('#success_message').html('');
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                    }
                    else{
                        let role = response.student.role;
                if(role === 'user')
                {
                    $('#role2').attr('checked','checked');
                    $('#role').val('user');
                }
                if(role === 'admin')
                {
                    $('#role1').attr('checked','checked');
                    $('#role').val('admin');
                }
                        $('#id').val(userId);
                        $('#username').val(response.student.username);
                        $('#email').val(response.student.email);
                        // $('#password').val(response.student.password);
                    }
                }
            })
        });



        $(document).on('click','#role1', function (){
                $('#role').val('admin');
        });
        $(document).on('click','#role2', function (){
                $('#role').val('user');
        });


        var $modal = $('#editModal');
        //when hidden
        $modal.on('hidden.bs.modal', function(e) {
            return this.render(); //DOM destroyer
        });




        $(document).on('click','#update_form', function (e){

            let data = {
            username : $('#username').val(),
                email : $('#email').val(),
            id : $('#id').val(),
            // password: $('#password').val(),
            role : $('#role').val(),
        };

        console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
         $.ajax({
             type:"PUT",
             url:'/update/',
             data:data,
             dataType:"json",
             success: function (response)
            {
                if(response.status === 200)
                {
                    if(response.message === 'success')
                    {
                        window.location.replace('/show')

                    }
                    $modal.modal('hide');
                }
                if(response.status === 400){
                    $.each(response.error,function (prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                }
            }
         })
        });
        $("#user-table").on("click",".deleteRecord",function ()
        {
            if(confirm('Are you sure you want to delete'))
            {
                var id = $(this).attr("data-id");
                    var obj = $(this)
                    $.ajax({
                        type:"GET",
                        url:"delete/"+id,
                        success:function ()
                        {
                            $(obj).parent().parent().remove();
                            $('#output').text(data.result);
                        },
                        error:function (err){
                            console.log(err.responseText)
                        },
                    });
            }
        });






    });






</script>


{{--<script>--}}
{{--    document.querySelector('input[name=submit_change]').addEventListener('click', function(e) {--}}
{{--        e.preventDefault();--}}

{{--        window.location.reload();--}}
{{--    });--}}
{{--</script>--}}

















<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
