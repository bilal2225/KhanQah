<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todoapp;
use Validator;

class TodoController extends Controller
{
    public function index()
    {
        $products = Todoapp::all();
    
        return response()->json([
            'message' => 'data Receive successfully'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return response()->json([
                'message' => 'some thing went wrong'
            ]);
        }
   
        $product = Todoapp::create($input);
   
        return response()->json([
            'message' => 'added successfully'
        ]);
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Todoapp::find($id);
  
        if (is_null($product)) {
           
                return response()->json([
                    'message' => 'some thing went wrong'
                ]);
            
       
        }
   
        return response()->json([
            'message' => 'added successfully'
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todoapp $product)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return response()->json([
                'message' => 'failed'
            ]);   
        }
   
        $product->name = $input['title'];
        $product->detail = $input['description'];
        $product->save();
   
        return response()->json([
            'message' => 'updated successfully'
        ]);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todoapp $product)
    {
        $product->delete();
   
        return response()->json([
            'message' => 'deleted cessfully'
        ]);
    }
}
