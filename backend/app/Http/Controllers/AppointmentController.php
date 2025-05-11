<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function createAppointment(Request $request){

        try {
            $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',

        ]);

        if($validator->fails()){
            return response()->json(['success'=>false, 'message'=>$validator->errors()], 400);
        }

        if($request->type == 'servicing'){
            $appointment = Appointment::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'note'=>$request->note,
                'type'=>$request->type,
                'status'=>'pending',


            ]);
        }else{
             $appointment = Appointment::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'note'=>$request->note,
                'bike_variant_color_id'=>$request->bikeVariantColorId,
                'type'=>$request->type,
                'status'=>'pending',


            ]);

        }
        return response()->json(['success'=>true, 'message'=>"Appointment has been submitted. We'll reach you back soon."], 200);

        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
        
        



        
    }
}
