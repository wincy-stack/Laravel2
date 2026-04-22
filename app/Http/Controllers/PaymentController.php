<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['order.user', 'order.rice'])->get();
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::whereDoesntHave('payment')->get();
        return view('payment.create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:Paid,Unpaid',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        // Check if payment already exists for this order
        if ($order->payment) {
            return back()->with('error', 'Payment already exists for this order.');
        }

        $payment_date = $validated['status'] === 'Paid' ? now() : null;

        Payment::create([
            'order_id' => $validated['order_id'],
            'amount' => $order->total_amount,
            'status' => $validated['status'],
            'payment_date' => $payment_date,
        ]);

        return redirect()->route('payment.index')->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return view('payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return view('payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:Paid,Unpaid',
        ]);

        $payment_date = $validated['status'] === 'Paid' ? now() : null;

        $payment->update([
            'status' => $validated['status'],
            'payment_date' => $payment_date,
        ]);

        return redirect()->route('payment.show', $payment->id)->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully!');
    }
}
