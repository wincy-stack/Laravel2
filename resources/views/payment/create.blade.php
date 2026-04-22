@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"> Record Payment</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="order_id" class="form-label">Select Order *</label>
                            <select class="form-control @error('order_id') is-invalid @enderror" 
                                    id="order_id" name="order_id" onchange="updateOrderDetails()" required>
                                <option value="">-- Select an order --</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}" 
                                            data-amount="{{ $order->total_amount }}"
                                            data-customer="{{ $order->user->name }}"
                                            data-rice="{{ $order->rice->name }}"
                                            data-quantity="{{ $order->quantity }}">
                                        Order #{{ $order->id }} - {{ $order->user->name }} - ₱{{ number_format($order->total_amount, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Orders with no payment record</small>
                            @error('order_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Customer</h6>
                                        <p id="customerName">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Rice Item</h6>
                                        <p id="riceItem">-</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Quantity</h6>
                                        <p id="quantity">-</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Amount Due</h6>
                                        <h4 class="text-primary">₱<span id="amount">0.00</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Payment Status *</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">-- Select status --</option>
                                <option value="Paid" {{ old('status') === 'Paid' ? 'selected' : '' }}>✓ Paid</option>
                                <option value="Unpaid" {{ old('status') === 'Unpaid' ? 'selected' : '' }}> Unpaid</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Record Payment</button>
                            <a href="{{ route('payment.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const orderSelect = document.getElementById('order_id');

    function updateOrderDetails() {
        const selectedOption = orderSelect.options[orderSelect.selectedIndex];
        const amount = selectedOption.dataset.amount || '0.00';
        const customer = selectedOption.dataset.customer || '-';
        const rice = selectedOption.dataset.rice || '-';
        const quantity = selectedOption.dataset.quantity || '-';

        document.getElementById('amount').textContent = parseFloat(amount).toFixed(2);
        document.getElementById('customerName').textContent = customer;
        document.getElementById('riceItem').textContent = rice;
        document.getElementById('quantity').textContent = quantity + ' kg';
    }
</script>
@endsection
