<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function getAccessories(Request $request){

        try{

            $bikes = Accessory::with('brand')->paginate($request->limit);

            return response()->json(['success'=>'true', 'message'=>'Accessories fetch successful', 'data'=>$bikes], 200);

        }catch(\Exception $e){

             return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }

    }

    public function getAccessoryBySlug(string $slug){

        try {
            $bike = Accessory::with(['brand', 'accessoryVariant'=>function($query){
                $query->with(['accessoryVariantColor'=>function($query){
                    $query->with('color');
                }]);
            }])->where('slug', $slug)->first();


            return response()->json(['success'=>'true', 'message'=>'Bike fetch successful', 'data'=>$bike], 200);

        } catch (\Exception $e) {
             return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }

    }
}
