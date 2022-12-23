<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\API\LoginUserController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BooksController;
use App\Http\Controllers\API\UserController;

//<---------logout-------->
Route::get('/logout',function (){
    if(session()->has('role')) {
        session()->pull('role');
    }
    return redirect('/');
});
//<---------end-logout------------------->








//<---------homeRoute--------------->


//< ---------end-homeRoute--------------->




//<------------login using Ajax----------->
Route::middleware('login')->group(function() {
    Route::get('/',function(){
        return view('home');
    });
    Route::post('/login', [LoginUserController::class, 'loginUser']);
    Route::post('/selectLanguage',[LoginUserController::class,'selectLanguage']);
});
//<------------end-login using Ajax----------->







//<-----------------------------admin routes------------------------------------->


Route::middleware('guard')->group(function() {
    Route::view('/admin','admin');
    Route::view('storeIndex','layout/store');
    Route::post('/store',[AdminController::class,'store']);
    Route::get('/showUser',[AdminController::class,'index'])->name('index');
    Route::view('/show','layout.showUser');
    Route::get('delete/{id}',[AdminController::class,'destroy']);
    Route::get('/edit/{id}',[AdminController::class,'edit']);
    Route::put('update',[AdminController::class,'update']);
    Route::view('storeIndex','layout/store');
    Route::post('/store',[AdminController::class,'store']);
    Route::get('/showUser',[AdminController::class,'index']);
    Route::view('/show','layout.showUser');
    Route::get('delete/{id}',[AdminController::class,'destroy']);
    Route::get('/edit/{id}',[AdminController::class,'edit']);
    Route::put('update',[AdminController::class,'update']);
    Route::view('addBooks','books/addBooks');
    Route::post('addBook',[BooksController::class,'store']);
    Route::get('/showBook',[BooksController::class,'show']);
    Route::get('deleteBook/{id}',[BooksController::class,'destroy']);
    Route::get('editBook/{id}',[BooksController::class,'edit']);
    Route::put('/updateBook',[BooksController::class,'update']);

    Route::post('/assignBook',[AdminController::class,'assign']);
    Route::get('/editassign',[AdminController::class,'AssigntoUser']);
    Route::view('/assignBook','layout/assignBook');
    Route::get('/edit',function (){
        return view('layout/edit');
    });
    Route::view('/showBooks','books/showBooks');

});






//<--------------------------------normal user route------------------------------->

Route::middleware('guard1')->group(function() {
    Route::view('/user', 'normalUser');
    Route::get('/search/{search?}', [UserController::class, 'search']);
    Route::get('editProfile',[UserController::class,'edit']);
    Route::put('updateProfile',[UserController::class,'update']);
});



//<--------------------------------normal user route------------------------------->

