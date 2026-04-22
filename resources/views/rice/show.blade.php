@extends('layouts.app')

@section('title', 'View Rice - ' . $rice->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">{{ $rice->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Price per Kilogram</h6>
                            <h3 class="text-primary">₱{{ number_format($rice->price_per_kg, 2) }}</h3>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Stock Available</h6>
                            <h3 class="text-success">{{ $rice->stock }} kg</h3>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-muted">Description</h6>
                    <p>{{ $rice->description ?? 'No description provided' }}</p>

                    <h6 class="text-muted mt-4">Date Created</h6>
                    <p>{{ $rice->created_at->format('M d, Y h:i A') }}</p>

                    <h6 class="text-muted">Last Updated</h6>
                    <p>{{ $rice->updated_at->format('M d, Y h:i A') }}</p>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('rice.edit', $rice->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('rice.destroy', $rice->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('rice.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
