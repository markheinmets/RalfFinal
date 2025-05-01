<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Add product to the cart
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image, // Assuming the product has an image column
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    // Update the quantity of a product in the cart
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart');

        if ($request->has('quantity')) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    // Remove product from the cart
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    // View cart
    public function index()
    {
        $cart = session()->get('cart');
        return inertia('Cart/Index', [
            'cart' => $cart
        ]);
    }
}
