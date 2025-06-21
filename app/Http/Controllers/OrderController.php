<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // Place order (checkout)
    public function checkout(Request $request)
    {
        $cartItems = Cart::with('service')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->service->price * $item->quantity;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $item->service_id,
                'quantity' => $item->quantity,
                'price' => $item->service->price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        Mail::to(Auth::user()->email)->send(new OrderInvoiceMail($order));

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    // Show all orders for user
    public function index()
    {
        $orders = Order::with('items.service')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders', compact('orders'));
    }

    // Show single order details
    public function show($orderId)
    {
        $order = Order::with('items.service')
            ->where('user_id', Auth::id())
            ->where('id', $orderId)
            ->firstOrFail();

        return view('orders', compact('order'));
    }

    public function showOrdersToAdmin()
    {
        $orders = Order::with(['user', 'items.service'])->latest()->get();
        return view('panel.admin.orders', compact('orders'));
    }

    public function coupleOrderHistory()
    {
        $orders = Order::with('items.service')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('panel.couple.couple_order_history', compact('orders'));
    }

    public function vendorOrders()
    {
        $vendorId = Auth::id();

        // Get all order IDs that have at least one item for this vendor
        $orderIds = OrderItem::whereHas('service', function($q) use ($vendorId) {
            $q->where('user_id', $vendorId);
        })->pluck('order_id')->unique();

        // Get those orders with user and items (eager load service for items)
        $orders = Order::with(['user', 'items.service'])
            ->whereIn('id', $orderIds)
            ->latest()
            ->get();

        return view('panel.vendor.order.index', compact('orders'));
    }
}
