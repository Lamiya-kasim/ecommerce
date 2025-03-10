<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 🛑 1️⃣ Validate input
        $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_address' => 'required',
            'payment_method' => 'required',
            'items' => 'required|array',
            'total_price' => 'required|numeric',
        ]);

        // ✅ 2️⃣ Save Order
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
            'payment_method' => $request->payment_method,
            'total_price' => $request->total_price,
        ]);

        // ✅ 3️⃣ Save Order Items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'product_price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // ✅ 4️⃣ Return Success Response
        return response()->json(['message' => 'Order placed successfully!'], 200);
    }
}
