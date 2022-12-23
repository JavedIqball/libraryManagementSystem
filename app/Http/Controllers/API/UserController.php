<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\book_userInfo;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($search = false)
    {
//            $users  = Book::all();


        $loggedInUserId = Auth::user()['id'];

         $booksId =  book_userInfo::where('usersid',$loggedInUserId)->pluck('bookId')->toArray();
        $users=[];
         foreach ($booksId as $bookId){

             array_push($users,Book::find($bookId)->toArray());

         }

        if($search){

            $users = Book::where('title','LIKE',"%$search%")->get();
        }

        return response()->json(['status'=>200,'users'=>$users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit()
    {

           $userId =  Auth::user()['id'];

           $userId = User::find($userId);

        if($userId){
            return response()->json([
                'status'=>200,
                'student'=>$userId,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'user not found',
            ]);

    }}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {


        $validator = Validator::make($request->all(),[
            'username'=>'required',
            'email'=>'required|email',

        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400,
                'errors'=>$validator->messages(),

            ]);
        }

         $data =  Auth::user()['id'];

         $data = User::find($data);

         $data->username = $request->username;
         $data->email = $request->email;
//         $data->password = $request->password;
         $data->update();
         if($data->update()){
             return response()->json([
                 'status' => 200,
                 'message' => 'success'
             ]);
         }else{
             return response()->json([
                 'status'=>404,
                 'message'=>'user not found',
             ]);
         }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
