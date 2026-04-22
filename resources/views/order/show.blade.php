@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Order #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Customer Name</h6>
                            <p><strong>{{ $order->user->name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Date Ordered</h6>
                            <p>{{ $order->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Rice Product</h6>
                            <p><strong>{{ $order->rice->name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Price per kg</h6>
                            <p>₱{{ number_format($order->rice->price_per_kg, 2) }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Quantity</h6>
                            <p><strong>{{ $order->quantity }} kg</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Total Amount</h6>
                            <h3 class="text-success">₱{{ number_format($order->total_amount, 2) }}</h3>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h6 class="text-muted">Payment Status</h6>
                        @if($order->payment)
                            @if($order->payment->status === 'Paid')
                                <span class="badge bg-success" style="font-size: 14px;">PAID</span>
                                <p class="mt-2">Paid on: {{ $order->payment->payment_date->format('M d, Y h:i A') }}</p>
                            @else
                                <span class="badge bg-warning" style="font-size: 14px;">UNPAID</span>
                                <p class="mt-2">
                                    <a href="{{ route('payment.create') }}?order_id={{ $order->id }}" class="btn btn-sm btn-primary">Process Payment</a>
                                </p>
                            @endif
                        @else
                            <span class="badge bg-secondary" style="font-size: 14px;">NO PAYMENT RECORD</span>
                            <p class="mt-2">
                                <a href="{{ route('payment.create') }}?order_id={{ $order->id }}" class="btn btn-sm btn-primary">Create Payment Record</a>
                            </p>
                        @endif
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('order.edit', $order->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('order.destroy', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('order.index') }}" class="btn btn-secondary">Back to Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
