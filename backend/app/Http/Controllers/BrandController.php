<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function getBrands(Request $request){

        try{

            $brands = Brand::get();

            return response()->json(['success'=>'true', 'message'=>'Brands fetched successful', 'data'=>$brands], 200);

        }catch(\Exception $e){

             return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }

    }
}
