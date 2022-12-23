<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<body>
<x-header />
<div class="container">
    <input type="hidden" value="" id="id" name="id">
    <div class="mb-3">
            <label for="username" class="form-label">username</label>

            <input type="username" class="form-control" id="username" value="" name="username" aria-describedby="username">
            <span class="text-danger error-text username_error"></span>
        </div>          <label for="email" class="form-label">Email address</label>
{{--            <input type="email" class="form-control" id="email" value="{{$data->email}}" name="email" aria-describedby="email">--}}
            <input type="email" class="form-control" id="email" value="" name="email" aria-describedby="email">
            <span class="text-danger error-text email_error"></span>
        </div>
    <div class="mb-3">
            <label for="password" class="form-label">Password</label>
{{--            <input type="password" class="form-control" name="password" value="{{$data->password}}" id="password">--}}
            <input type="password" class="form-control" name="password" value="" id="password">
            <span class="text-danger error-text password_error" ></span>

        </div>
    <div class="form-check">
            <input type="radio" id="role1" name="role" value="admin" >
            <label for="radio">
                Admin </label>
            <input type="radio" id="role2" name="role" value="user">
            <label for="radio">
                User</label><br>
            <span class="text-danger error-text role_error" ></span>
        </div>
    <input type="hidden" name="role" id ="role" value=""/>
    <button type="submit" class="btn btn-primary" id="update_form">Update</button>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>


