<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\book_userInfo;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::with('books')->get();

        return response()->json(['users'=>$users,'status'=>200]);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {


        $validator1 = Validator::make($request->all(),[
            'username'=>'required',
            'email'=>'required|email'
        ]);
        if($validator1->fails()){
            return response()->json(['status'=>412,'error'=>$validator1->errors()->toArray()]);
        }

        $data = new User;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = Str::random(8);
        $this->randomPasswordMail($data->password,$data->email,$data->username);
        $data->password = Hash::make($data->password);
        $data->role = $request->role;
        $save =$data->save();

        if($save){
            return response()->json(['status'=>200,'message'=>'success']);
        }


    }
    private function randomPasswordMail($password,$email,$username)
    {
        $data = ['email'=>$email, 'password'=>$password,'name'=>$username];
        $user['to'] = $email;
        Mail::send('mail',$data, function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('New User Password');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {

        $user = User::find($id);

        if($user){
            return response()->json([
                'status'=>200,
                'student'=>$user,
            ]);
        }else{
            return response()->json([
               'status'=>404,
               'message'=>'user not found',
            ]);
        }




    }




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
//            'password'=>'required|min:5',
            'role'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400,
                'errors'=>$validator->messages(),

            ]);
        }


            $data = User::find($request->id);
                if($data) {

                    $data->username = $request->username;
                    $data->email = $request->email;
//                    $data->password = Hash::make($request->password);
                    $data->role = $request->role;
                    $data->update();
                    return response()->json([
                        'status' => 200,
                        'message' => 'updated successfully'
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'user not found',
                    ]);
                }




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        User::where('id',$id)->delete();
        return response()->json(['result'=>'success']);




    }

    public function assign(Request $request)
    {
        $book = Book::where('title',$request['book'])->first();

        book_userInfo::updateOrCreate(['usersid'=>$request->usersid,'bookId'=>$book->id]);
     $this->mailToUser($request->usersid,$book->title);
        return response()->json([
            'status'=>200
        ]);

    }
    public function mailToUser($userId,$bookTitle)
    {



         $user = User::where('id',$userId)->first();

        $data = ['name'=>$user->username,'book'=>$bookTitle];
        $user['to'] = $user->email;
        Mail::send('bookAssignMail',$data, function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('New Book has assigned');
        });
    }
    public function AssigntoUser()
    {

        $users = Book::all();

        return response()->json([
           'users'=>$users,
            'status'=>200,
        ]);



    }








}
