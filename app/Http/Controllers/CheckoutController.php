<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    // Display the checkout form (Inertia page)
    public function showCheckoutForm()
    {
        return Inertia::render('Checkout/Index');
    }

    // Process the payment
    public function processPayment(Request $request)
    {
        // Validate the input data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|string', // Stripe payment method ID
        ]);

        // Set your Stripe Secret Key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Create a PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => 1000, // Amount in cents (e.g., $10.00 = 1000)
                'currency' => 'usd',
                'payment_method' => $request->payment_method, // Payment method ID from frontend
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success'),
            ]);

            if ($paymentIntent->status === 'succeeded') {
                session()->forget('cart'); // Clear cart after successful payment
                return redirect()->route('payment.success');
            } else {
                return redirect()->route('payment.failed');
            }
        } catch (\Exception $e) {
            // Handle errors
            return redirect()->route('payment.failed')->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Handle payment success (Inertia page)
    public function paymentSuccess()
    {
        return Inertia::render('Checkout/Success');
    }

    // Handle payment failure (Inertia page)
    public function paymentFailed()
    {
        return Inertia::render('Checkout/Failed');
    }
}
