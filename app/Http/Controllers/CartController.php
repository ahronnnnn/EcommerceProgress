<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function store(Request $request)
    {
        // Find the product by its ID
        $product = Product::findOrFail($request->input('product_id'));

        // Get the quantity from the form, default to 1
        $quantity = $request->input('quantity', 1);

        // Check if there is enough stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');


            Cart::add($product->id, $product->name, $quantity, $product->price, ['image' => 'default.jpg']);

    return redirect()->route('shop.index')->with('success', 'Product added to cart!');
        }

        // Get the current cart from session (or empty array if none)
        $cart = session()->get('cart', []);

        // If product is already in cart, increase quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => 'default.jpg' // Replace with actual image if you have one
            ];
        }

        // Save the cart back to session
        session()->put('cart', $cart);

        // Redirect back with success message
        return redirect()->route('shop.index')->with('success', 'Product added to cart!');
    }

    public function index()
    {   
        // The package automatically gets the cart from the session
        // $cartItems = Cart::content(); // This is a Collection
        // $cartTotal = Cart::total();
        // $cartCount = Cart::count();

        // No logic needed, just return the view.
        // We can access Cart::content() directly in Blade.
        return view('cart.index');
    }
    //  
    public function destroy($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    // Clear the entire cart
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }



}
