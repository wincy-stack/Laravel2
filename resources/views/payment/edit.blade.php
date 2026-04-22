@extends('layouts.app')

@section('title', 'Edit Payment #' . $payment->id)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"> Edit Payment #{{ $payment->id }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="text-muted">Order Details</h6>
                                <p class="mb-1">
                                    <strong>Order #:</strong> {{ $payment->order->id }}
                                </p>
                                <p class="mb-1">
                                    <strong>Customer:</strong> {{ $payment->order->user->name }}
                                </p>
                                <p class="mb-1">
                                    <strong>Rice Item:</strong> {{ $payment->order->rice->name }}
                                </p>
                                <p class="mb-1">
                                    <strong>Quantity:</strong> {{ $payment->order->quantity }} kg
                                </p>
                                <hr>
                                <h5 class="text-primary">Amount: ₱{{ number_format($payment->amount, 2) }}</h5>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Payment Status *</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">-- Select status --</option>
                                <option value="Paid" {{ old('status', $payment->status) === 'Paid' ? 'selected' : '' }}> Paid</option>
                                <option value="Unpaid" {{ old('status', $payment->status) === 'Unpaid' ? 'selected' : '' }}> Unpaid</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        @if($payment->payment_date)
                            <div class="mb-3">
                                <label class="form-label">Payment Date</label>
                                <p>{{ $payment->payment_date->format('M d, Y h:i A') }}</p>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">Update Payment</button>
                            <a href="{{ route('payment.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>













































































































































































































                
            </div>
        </div>
    </div>
</div>
@endsection
