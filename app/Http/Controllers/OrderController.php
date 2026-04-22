<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'rice', 'payment'])->get();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rices = Rice::all();
        return view('order.create', compact('rices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rice_id' => 'required|exists:rice,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $rice = Rice::findOrFail($validated['rice_id']);
        
        // Check stock
        if ($rice->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock for this item.');
        }

        // Calculate total amount
        $total_amount = $rice->price_per_kg * $validated['quantity'];

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'rice_id' => $validated['rice_id'],
            'quantity' => $validated['quantity'],
            'total_amount' => $total_amount,
        ]);

        // Deduct from stock
        $rice->update(['stock' => $rice->stock - $validated['quantity']]);

        return redirect()->route('order.show', $order->id)->with('success', 'Order created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $rices = Rice::all();
        return view('order.edit', compact('order', 'rices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'rice_id' => 'required|exists:rice,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $rice = Rice::findOrFail($validated['rice_id']);

        // Restore original stock
        $original_rice = Rice::findOrFail($order->rice_id);
        $original_rice->update(['stock' => $original_rice->stock + $order->quantity]);

        // Check new stock
        if ($rice->stock < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock for this item.');
        }

        // Calculate new total
        $total_amount = $rice->price_per_kg * $validated['quantity'];

        $order->update([
            'rice_id' => $validated['rice_id'],
            'quantity' => $validated['quantity'],
            'total_amount' => $total_amount,
        ]);

        // Deduct new stock
        $rice->update(['stock' => $rice->stock - $validated['quantity']]);

        return redirect()->route('order.show', $order->id)->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Restore stock when deleting order
        $rice = $order->rice;
        $rice->update(['stock' => $rice->stock + $order->quantity]);

        $order->delete();
        return redirect()->route('order.index')->with('success', 'Order deleted successfully!');
    }
}
