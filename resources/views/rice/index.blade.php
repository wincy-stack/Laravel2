@extends('layouts.app')

@section('title', 'Rice Products')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Rice Products Management</h2>
        <a href="{{ route('rice.create') }}" class="btn btn-primary">+ Add New Rice</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rice Name</th>
                            <th>Price per kg</th>
                            <th>Stock (kg)</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rices as $rice)
                            <tr>
                                <td>{{ $rice->id }}</td>
                                <td><strong>{{ $rice->name }}</strong></td>
                                <td>₱{{ number_format($rice->price_per_kg, 2) }}</td>
                                <td>
                                    @if($rice->stock < 10)
                                        <span class="badge bg-danger">{{ $rice->stock }}</span>
                                    @elseif($rice->stock < 50)
                                        <span class="badge bg-warning">{{ $rice->stock }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $rice->stock }}</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($rice->description, 50) }}</td>
                                <td>
                                    <a href="{{ route('rice.show', $rice->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('rice.edit', $rice->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('rice.destroy', $rice->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">No rice products found. <a href="{{ route('rice.create') }}">Add one now</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
