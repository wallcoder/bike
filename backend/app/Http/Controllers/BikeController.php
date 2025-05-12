<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Exception;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function getBikes(Request $request){

        try{

            $bikes = Bike::with('brand')->paginate($request->limit);

            return response()->json(['success'=>'true', 'message'=>'Bikes fetch successful', 'data'=>$bikes], 200);

        }catch(Exception $e){

             return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }

    }

    public function getBikeBySlug(string $slug){

        try {
            $bike = Bike::with(['brand', 'bikeVariant'=>function($query){
                $query->with(['bikeVariantColor'=>function($query){
                    $query->with('color');
                }]);
            }])->where('slug', $slug)->first();


            return response()->json(['success'=>'true', 'message'=>'Bike fetch successful', 'data'=>$bike], 200);

        } catch (Exception $e) {
             return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }

    }

  
}
