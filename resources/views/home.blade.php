<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <link rel="stylesheet" href="{{asset('css/mycss.css')}} " type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
{{--navbar--}}
<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">lms</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ml-auto">
                <li class="nav-item px-2">
                    <a class="nav-link active text-light " aria-current="page" href="#">{{__('lang.Home')}}</a>
                </li>
                <form action="/selectLanguage" method="post">
                    @csrf
                <select name="lang">
                    <option value="en">{{__('lang.English')}}</option>
                    <option value="hi">{{__('lang.Hindi')}}</option>
                </select>
                    <button type="submit" class="btn btn-outline-light btn-sm">{{__('lang.submit')}}</button>
                </form>
            </ul>

        </div>
    </div>
</nav>


{{--alert--}}
<div class="alert alert-warning alert-dismissible fade show" id='message'role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong></strong>
</div>

<section id="cover" class="min-vh-100">
    <div id="cover-caption">
        <div class="container">
            <div class="row text-white">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4 ">
                    <h1 class="display-4 py-2 text-truncate">{{__('lang.lms')}}</h1>
                    <div class="px-2">


{{--                        <form action="{{asset('login')}}" method="POST" class="justify-content-center was-validated login_form" id="main_form">--}}

                            @csrf

                            <div class="form-group " >

                                <label class="email">{{__('lang.email')}} </label>
                                <input type="email" class="form-control"  id="email"  name="email" placeholder="">
                                <span class="text-danger error-text email_error" ></span>
                            </div>
                            <div class="form-group mb-3">
                                <label class="password">{{__('lang.password')}}</label>

                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="">
                                <span class="text-danger error-text password_error"></span>
                            </div>

                            <button type="submit" class="btn btn-success" id="main_form">{{__('lang.submit')}}</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{asset('js/LoginUser.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
