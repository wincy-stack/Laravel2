@extends('layouts.app')

@section('title', 'Payment Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payment Management</h2>
        <a href="{{ route('payment.create') }}" class="btn btn-primary">+ Record Payment</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Date</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>#{{ $payment->id }}</td>
                                <td>
                                    <a href="{{ route('order.show', $payment->order->id) }}">
                                        #{{ $payment->order->id }}
                                    </a>
                                </td>
                                <td>{{ $payment->order->user->name }}</td>
                                <td>₱{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @if($payment->status === 'Paid')
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-warning">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payment->payment_date)
                                        {{ $payment->payment_date->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">No payments found. <a href="{{ route('payment.create') }}">Record one now</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
