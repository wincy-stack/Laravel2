@extends('layouts.app')

@section('title', 'Edit Order #' . $order->id)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"> Edit Order #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="rice_id" class="form-label">Select Rice Product *</label>
                            <select class="form-control @error('rice_id') is-invalid @enderror" 
                                    id="rice_id" name="rice_id" onchange="updatePrice()" required>
                                <option value="">-- Select a rice product --</option>
                                @foreach($rices as $rice)
                                    <option value="{{ $rice->id }}" 
                                            data-price="{{ $rice->price_per_kg }}" 
                                            data-stock="{{ $rice->stock + $order->quantity }}"
                                            {{ old('rice_id', $order->rice_id) == $rice->id ? 'selected' : '' }}>
                                        {{ $rice->name }} - ₱{{ number_format($rice->price_per_kg, 2) }}/kg
                                    </option>
                                @endforeach
                            </select>
                            @error('rice_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity (kg) *</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" name="quantity" value="{{ old('quantity', $order->quantity) }}" 
                                       step="0.1" min="0.1" oninput="calculateTotal()" required>
                                <span class="input-group-text">kg</span>
                            </div>
                            <small class="text-muted">Maximum available: <span id="maxStock">{{ $rices->firstWhere('id', $order->rice_id)->stock + $order->quantity }}</span> kg</small>
                            @error('quantity')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="text-muted">Price per kg</h6>
                                <h4 class="text-primary">₱<span id="pricePerKg">{{ $order->rice->price_per_kg }}</span></h4>

                                <hr>

                                <h6 class="text-muted">Total Amount</h6>
                                <h3 class="text-success">₱<span id="totalAmount">{{ $order->total_amount }}</span></h3>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">Update Order</button>
                            <a href="{{ route('order.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const riceSelect = document.getElementById('rice_id');
    const quantityInput = document.getElementById('quantity');
    const pricePerKgSpan = document.getElementById('pricePerKg');
    const totalAmountSpan = document.getElementById('totalAmount');
    const maxStockSpan = document.getElementById('maxStock');

    function updatePrice() {
        const selectedOption = riceSelect.options[riceSelect.selectedIndex];
        const price = selectedOption.dataset.price || 0;
        const stock = selectedOption.dataset.stock || 0;
        
        pricePerKgSpan.textContent = parseFloat(price).toFixed(2);
        maxStockSpan.textContent = stock;
        calculateTotal();
    }

    function calculateTotal() {
        const price = parseFloat(pricePerKgSpan.textContent) || 0;
        const quantity = parseFloat(quantityInput.value) || 0;
        const total = price * quantity;
        
        totalAmountSpan.textContent = total.toFixed(2);
    }

    // Initialize on page load
    updatePrice();
</script>
@endsection
