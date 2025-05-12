<?php

namespace App\Http\Controllers;

use App\Models\AccessoryVariantColor;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderInvoiceMail;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;



class PaymentController extends Controller
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function createOrder(Request $request)
    {
        $order = $this->razorpay->order->create([
            'receipt' => 'rcptid_' . uniqid(),
            'amount' => $request->amount,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        return response()->json($order->toArray());
    }

    public function verifyPayment(Request $request)
    {
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            $this->razorpay->utility->verifyPaymentSignature($attributes);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Razorpay verification failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function storeInfo(Request $request)
{
    DB::beginTransaction();

    try {
        $cartItems = CartItem::where('user_id', $request->user()->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Cart is empty'], 400);
        }

        $order = Order::create([
            'user_id' => $request->user()->id,
            'total' => $request->total,
            'status' => 'pending',
            'full_name' => $request->name,
            'phone' => $request->phone,
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postalCode,
            'country' => $request->country,
        ]);

        foreach ($cartItems as $cartItem) {
            // Lock the row for update to avoid race condition
            $variant = AccessoryVariantColor::where('id', $cartItem->accessory_variant_color_id)->lockForUpdate()->first();

            if (!$variant) {
                throw new \Exception('Product variant not found.');
            }

            if ($variant->stock < $cartItem->quantity) {
                throw new \Exception("Not enough stock for item ID: {$variant->id}");
            }

            // Reduce stock
            $variant->stock -= $cartItem->quantity;
            $variant->save();

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'accessory_variant_color_id' => $variant->id,
                'name' => $variant->accessoryVariant->accessory->model, 
                'description' => $variant->accessoryVariant->accessory->description ?? '',
                'price' => $cartItem->unit_price,
                'quantity' => $cartItem->quantity,
            ]);
        }

        Payment::create([
            'order_id'=>$order->id,
            'ref_id'=>$request->razorpay_payment_id,
            'method'=>'card',
            'status'=>'success',
            'amount'=>$request->total,
        ]);



        
        CartItem::where('user_id', $request->user()->id)->delete();

        DB::commit();

       

        return response()->json(['success' => true, 'message' => 'Order placed successfully', 'order' => $order]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
    }
}
}
