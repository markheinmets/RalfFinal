<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        return inertia('Checkout/Index');
    }

    public function processPayment(Request $request)
    {
        // Here, you would integrate a payment gateway, e.g., Stripe or PayPal
        // For now, let's assume the payment is successful:
        $paymentSuccessful = rand(0, 1) === 1;

        if ($paymentSuccessful) {
            session()->forget('cart'); // Clear the cart after successful payment
            return redirect()->route('payment.success');
        } else {
            return redirect()->route('payment.failed');
        }
    }

    public function paymentSuccess()
    {
        return inertia('Checkout/Success');
    }

    public function paymentFailed()
    {
        return inertia('Checkout/Failed');
    }
}

