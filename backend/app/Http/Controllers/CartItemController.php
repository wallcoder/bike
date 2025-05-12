<?php

namespace App\Http\Controllers;

use App\Models\AccessoryVariantColor;
use App\Models\CartItem;
use Exception;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function getCartItems(Request $request)
{
    try {
        $userId = $request->user()->id;

        $cartItems = CartItem::with([
    'accessoryVariantColor' => function ($query) {
        $query->select('id', 'accessory_variant_id', 'color_id', 'image') 
              ->with([
                  'color:id,name', 
                  'accessoryVariant' => function ($q) {
                      $q->select('id', 'accessory_id', 'name')
                        ->with([
                            'accessory:id,model,slug'
                        ]);
                  }
              ]);
    }
])
->where('user_id', $userId)
->get(['id', 'user_id', 'accessory_variant_color_id', 'quantity', 'unit_price']);


        return response()->json([
            'success' => true,
            'message' => 'Cart fetched',
            'data' => $cartItems
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


    public function addToCart(Request $request){
    try {
        $userId = $request->user()->id;

        if ($request->quantity <= 0) {
            return response()->json(['success'=>false, 'message'=>'Invalid quantity'], 400);
        }

        $check = CartItem::where('user_id', $userId)
            ->where('accessory_variant_color_id', $request->accessoryVariantColorId)
            ->first(); 

        $stock = AccessoryVariantColor::select('stock')
            ->where('id', $request->accessoryVariantColorId)
            ->first();

        if (!$stock) {
            return response()->json(['success'=>false, 'message'=>'Item not found'], 404);
        }

        if ($check) {
            $newQuantity = $check->quantity + $request->quantity;

            if ($newQuantity > $stock->stock) {
                return response()->json(['success'=>false, 'message'=>'Item limit exceeded'], 400);
            }

            $check->update(['quantity' => $newQuantity]);

            return response()->json(['success' => true, 'message' => 'Item added to cart'], 200);
        }

        if ($request->quantity > $stock->stock) {
            return response()->json(['success'=>false, 'message'=>'Item limit exceeded'], 400);
        }

        CartItem::create([
            'user_id' => $userId,
            'accessory_variant_color_id' => $request->accessoryVariantColorId,
            'quantity' => $request->quantity,
            'unit_price' => $request->unitPrice
        ]);

        return response()->json(['success' => true, 'message' => 'Item added to cart'], 200);

    } catch(Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

public function removeFromCart(Request $request)
{
    try {
        $userId = $request->user()->id;

        if ($request->quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid quantity'], 400);
        }

       
        $cartItem = CartItem::where('user_id', $userId)
            ->where('accessory_variant_color_id', $request->accessoryVariantColorId)
            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        
        if ($request->quantity > $cartItem->quantity) {
            return response()->json(['success' => false, 'message' => 'Cannot remove more than cart quantity'], 400);
        }

        
        $remainingQuantity = $cartItem->quantity - $request->quantity;

        if ($remainingQuantity > 0) {
            $cartItem->update(['quantity' => $remainingQuantity]);
        } else {
            $cartItem->delete();
        }

        return response()->json(['success' => true, 'message' => 'Item removed from cart'], 200);

    } catch (Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}



}
