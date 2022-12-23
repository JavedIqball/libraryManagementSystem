<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Book;
class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {

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

       $validator = Validator::make($request->all(),[

           'title'=>'required',
           'AuthorName'=>'required',
           'Cost'=>'required',
           'quantity'=>'required|max:3'

       ]);
       if($validator->fails()){
           return response()->json([
               'status'=>412,
               'error'=>$validator->messages(),
               ]);
       }




        $data = new Book;
        $data->title = $request->title;
        $data->AuthorName = $request->AuthorName;
        $data->Cost = $request->Cost;
        $data->quantity = $request->quantity;
          $save =  $data->save();
         if($save){
             return response()->json([
                'status'=>200,'message'=>'success',
             ]);
         }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $users = Book::all();

        return response()->json([
            'users'=>$users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {

        $data = Book::find($id)->toArray();
        if($data){
            return response()->json([
               'status'=>200,
               'data'=>$data
            ]);
        }
        elseif(!$data){
            return response()->json([
               'status'=>404,
            'message'=>'data not found'
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
//        dd($request->all());

        $validator = Validator::make($request->all(),[
           'title'=>'required',
           'AuthorName'=>'required',
           'Cost'=>'required',
            'quantity'=>'required'
        ]);
            if($validator->fails()){
                return response()->json([
                   'status'=>400,
                   'errors'=>$validator->messages(),
                ]);
            }

        $data =Book::find($request->id);
        if($data){

        $data->id = $request->id;
        $data->title = $request->title;
        $data->AuthorName = $request->AuthorName;
        $data->Cost = $request->Cost;
        $data->quantity = $request->quantity;
         $data->save();
            return response()->json([
                'status'=>200,
                'message'=>'updated successfully'
            ]);
        }
        else{
            return response()->json([
               'status'=>404,
               'message'=>'book not found'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
         Book::where('id',$id)->delete();

        return response()->json(['result'=>'success']);

    }
}
