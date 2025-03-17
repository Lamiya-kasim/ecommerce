<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Validate request data
        $request->validate([
            'items' => 'required|array',
            'total_price' => 'required|numeric',
        ]);

        // Store order in the database
        $order = Order::create([
            'user_id' => Auth::id(),
            'items' => json_encode($request->items),
            'total_price' => $request->total_price,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Order placed successfully!',
            'order' => $order
        ], 201);
    }
}
