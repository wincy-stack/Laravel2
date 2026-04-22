@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        <!-- Rice Statistics -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Rice Products</h5>
                    <h2 class="text-primary">{{ \App\Models\Rice::count() }}</h2>
                    <p class="text-muted">Total items in inventory</p>
                    <a href="{{ route('rice.index') }}" class="btn btn-sm btn-primary">View Products</a>
                </div>
            </div>
        </div>

        <!-- Orders Statistics -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <h2 class="text-info">{{ \App\Models\Order::count() }}</h2>
                    <p class="text-muted">Total orders placed</p>
                    <a href="{{ route('order.index') }}" class="btn btn-sm btn-info">View Orders</a>
                </div>
            </div>
        </div>

        <!-- Payments Statistics -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Payments Received</h5>
                    <h2 class="text-success">₱{{ \App\Models\Payment::where('status', 'Paid')->sum('amount') }}</h2>
                    <p class="text-muted">Total paid amount</p>
                    <a href="{{ route('payment.index') }}" class="btn btn-sm btn-success">View Payments</a>
                </div>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="col-md-3 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pending Payments</h5>
                    <h2 class="text-warning">₱{{ \App\Models\Payment::where('status', 'Unpaid')->sum('amount') }}</h2>
                    <p class="text-muted">Awaiting payment</p>
                    <a href="{{ route('payment.create') }}" class="btn btn-sm btn-warning">Process Payment</a>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row mt-4">
        <!-- Recent Orders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Rice</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Order::latest()->take(5)->get() as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->rice->name }}</td>
                                        <td>{{ $order->quantity }} kg</td>
                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No orders yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Low Stock Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Rice Name</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Rice::where('stock', '<', 10)->get() as $rice)
                                    <tr>
                                        <td>{{ $rice->name }}</td>
                                        <td><span class="badge bg-warning">{{ $rice->stock }} kg</span></td>
                                        <td>₱{{ number_format($rice->price_per_kg, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">All items have sufficient stock</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
