<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{

   public function getOrderItems(Request $request)
{
    try {
        $userId = $request->user()->id;

        $orderItems = Order::where('user_id', $userId)
            ->with([
                'orderItem',
                'payment'
                
            ])
            ->get(['id', 'total', 'status']);

        return response()->json([
            'success' => true,
            'message' => 'Orders fetched',
            'data' => $orderItems
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    
}
