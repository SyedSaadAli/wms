<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show cart page
    public function index()
    {
        $cartItems = Cart::with('service')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart', compact('cartItems'));
    }

    // Add service to cart
    public function add(Request $request, $serviceId)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('service_id', $serviceId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'service_id' => $serviceId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Service added to cart!');
    }

    // Remove item from cart
    public function remove($cartId)
    {
        $cartItem = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    // Update quantity
    public function update(Request $request, $cartId)
    {
        $cartItem = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->first();

        if ($cartItem && $request->quantity > 0) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }
}
