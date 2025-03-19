<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Get all orders
    public function getOrders()
    {
        $orders = Orders::all();
        return response()->json($orders);
    }

    // Create a new order
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_price' => 'required|numeric',
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $order = Orders::create($request->all());
        return response()->json($order, 201);
    }

    // Get a specific order by ID
    public function getOrder($orderId)
    {
        $order = Orders::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    // Update an order
    public function updateOrder(Request $request, $orderId)
    {
        $order = Orders::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'total_price' => 'numeric',
            'customer_id' => 'exists:customers,id',
            'order_date' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $order->update($request->all());
        return response()->json($order);
    }

    // Delete an order
    public function deleteOrder($orderId)
    {
        $order = Orders::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Order deleted'], 204);
    }
}
