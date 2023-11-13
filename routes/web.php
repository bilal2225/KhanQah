<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

    
    
Route::get('read2/{level?}', function ($level=1) { 
    // session()->flush();
    // dd(session()->all() );
    $contents = File::get(base_path('public/upload/json/1698736638_datafile.json'));
    $data = json_decode($contents, true);
    $levelIndexes = array_keys($data['Levels List'] );
    $levelData = null;
    $levelData = $data['Levels List'][$level]; 

    if ($levelData === null) {
        return  'Level not found';
    } else {
        return view('read2', ['data' => $levelData,'level_key'=>$level,'levelIndexes'=>$levelIndexes]);
    }
})->name('read2');

Route::post('updateJson', function (Request $request) { 
    $jsonString = File::get(base_path('public/upload/json/1698736638_datafile.json'));
    $data = json_decode($jsonString, true);
    $sessions = session()->all();
    $keys=[];
    $val=[];
    $data1=[];
    foreach($sessions as $k => $v)
    {     
        $key = substr($k, 3); // Remove the 'key' prefix
        if(array_key_exists($key, $data['Levels List']))
        {
            $keys[] = $k;
            $val[]=$v;
            $data['Levels List'][$key] = $v;
        }
    }
    // dd( $sessions,$keys,$val,$data);
    $updatedJsonString = json_encode($data['Levels List'], JSON_PRETTY_PRINT);
    
    $result = File::put(base_path('public/upload/json/1698736638_datafile'), $updatedJsonString);
    if( $result !== false ) {
        session()->flush();
        return back();
    }
    else 
    {
        return 'something went wrong';
    }      
})->name('updateJson');


// Route::post('sessionSetData/{index}/{data?}', function (Request $request, $index=1) {  
//     //      session()->flush();
//     dd($index,$keys = $request->keys, $request->values);  
//     session()->put("key".$index, $request->values);
//     $added = session()->get("key".$index);
//     if($added)
//     {
//         return response()->json(['session added successfully'],200);
//     }
//     else
//     {
//         return 'something went wrong';
//     }
// });  

Route::post('sessionSetData/{index}/{data?}', function (Request $request, $index = 1) {
    // Get the input data
    $keys = $request->keys;
    $values =$request->values;
    // dd($keys, $values);
    // dd(session()->all());
   $data =  User::merge_arrays($keys,  $values);
   session()->put("key".$index, $data);
   $added = session()->get("key".$index);
//    dd(session()->all());
       if($added)
       {
           return response()->json(['session added successfully'],200);
       }
       else
       {
           return 'something went wrong';
       }
//    dd($data);
    return response()->json(['session data updated successfully'], 200);
});
