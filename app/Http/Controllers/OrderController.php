<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
  public function index()
  {
    $orders = Order::orderBy('created_at', 'desc')->paginate(12);
    return view('admin.orders', compact('orders'));
  }
  public function show($id)
  {
    $order = Order::findOrFail($id);
    $orderItem = OrderItem::where('order_id', $id)->orderBy('id')->paginate(10);
    $transaction = Transaction::where('order_id', $id)->first();
    return view('admin.order-details', compact( 'order', 'orderItem', 'transaction'));
  }
  public function update_status(Request $request)
{
    $order = Order::findOrFail($request->order_id);

    $order->status = $request->order_status;

    if ($request->order_status == 'delivered') {
        $order->delivery_date = Carbon::now();
    }
    else if ($request->order_status == 'cancelled') {
        $order->canceled_date = Carbon::now();
    }

    $order->save();

    if ($request->order_status == 'delivered') {
        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if ($transaction) {
            $transaction->status = 'approved';
            $transaction->save();
        }
    }

    return back()->with("status", "Status changed successfully!");
}


public function order_cancel(Request $request)
{
    $order = Order::where('id', $request->order_id)->firstOrFail();

    $order->status = 'cancelled';
    $order->canceled_date = Carbon::now();
    $order->save();

    return back()->with('status', 'Order has been cancelled successfully!!');
}

}
