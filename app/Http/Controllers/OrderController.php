<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'customer_name' => 'required|string',
        'customer_email' => 'required|email',
        'customer_address' => 'required|string',
        'payment_method' => 'required|in:cash,card',
        'items' => 'required|array',
        'items.*.product_id' => 'required|integer',
        'items.*.quantity' => 'required|integer|min:1',
        'total_price' => 'required|numeric'
    ]);

    $order = Order::create($request->only(['customer_name', 'customer_email', 'customer_address', 'payment_method', 'total_price']));

    foreach ($request->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity']
        ]);
    }

    return response()->json(['message' => 'Order placed successfully!']);
}
}
