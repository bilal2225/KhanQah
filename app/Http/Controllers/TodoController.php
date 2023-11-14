<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todoapp;
use Validator;

class TodoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Todoapp::class);

        $user = Auth::user();
        $userId = $user->id;
        $products = Todoapp::where('user_id', $userId)->paginate(10);

        return response()->json([
            'products' => $products,
            'message' => 'data received successfully'
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'something went wrong'
            ]);
        }

        $user = Auth::user();
        $userId = $user->id;
        $input['user_id'] = $userId;
        $product = Todoapp::create($input);

        return response()->json([
            'message' => 'added successfully'
        ]);
    }

    public function show(Todoapp $todoApp)
    {
        $this->authorize('view', $todoApp);

        return response()->json([
            'product' => $todoApp,
            'message' => 'show successfully'
        ]);
    }

    public function update(Request $request, Todoapp $todoApp)
    {
        $this->authorize('update', $todoApp);

        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'failed'
            ]);
        }

        $todoApp->title = $input['title'];
        $todoApp->description = $input['description'];
        $todoApp->save();

        return response()->json([
            'message' => 'updated successfully'
        ]);
    }

    public function destroy(Todoapp $todoApp)
    {
        $this->authorize('delete', $todoApp);

        $todoApp->delete();

        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
