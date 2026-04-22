@extends('layouts.app')

@section('title', 'Payment #' . $payment->id)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Payment #{{ $payment->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Order ID</h6>
                            <p>
                                <a href="{{ route('order.show', $payment->order->id) }}">#{{ $payment->order->id }}</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Payment Date</h6>
                            <p>
                                @if($payment->payment_date)
                                    {{ $payment->payment_date->format('M d, Y h:i A') }}
                                @else
                                    <span class="text-muted">Not yet paid</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Customer</h6>
                            <p><strong>{{ $payment->order->user->name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Rice Item</h6>
                            <p><strong>{{ $payment->order->rice->name }}</strong></p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Quantity</h6>
                            <p>{{ $payment->order->quantity }} kg</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Payment Amount</h6>
                            <h3 class="text-primary">₱{{ number_format($payment->amount, 2) }}</h3>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h6 class="text-muted">Payment Status</h6>
                        @if($payment->status === 'Paid')
                            <span class="badge bg-success" style="font-size: 16px;"> PAID</span>
                        @else
                            <span class="badge bg-warning" style="font-size: 16px;"> UNPAID</span>
                        @endif
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('payment.index') }}" class="btn btn-secondary">Back to Payments</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
