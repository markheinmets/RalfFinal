<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class CartController extends Controller
{
    // Add product to the cart
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->input('quantity', 1);
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->input('quantity', 1),
                'image' => $product->image,
                'description' => $product->description,
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['message' => 'Added to cart', 'cart' => $cart]);
    }

    // Update cart quantity
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart');
        $cart[$request->productId]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return response()->json(['cart' => $cart]);
    }

    // Remove product from cart
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        return Inertia::render('Cart/Index', [
        'cart' => $cart,  // Pass the updated cart to the Inertia view
    ]);
    }

    // Display cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return Inertia::render('Cart/Index', [
            'cart' => $cart,
        ]);
    }
}

