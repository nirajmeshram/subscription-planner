@extends('layouts.master')
@section('content')
    <div class="main-content" id="main-content">
        <h2>Edit Plan</h2>
        @if (Session::has('error'))
            <div class="alert alert-danger custom-error alert-dismissible fade show mt-2" role="alert">
                <h6>
                    <i class="bi bi-exclamation-circle" style="margin-right: 5px;"></i>
                    {{ Session::get('error') }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('plan.update', $plan->id) }}" method="post">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Enter plan name" name="name" value="{{ $plan->name }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                    placeholder="Enter price" name="price" value="{{ $plan->price }}">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <a class="btn btn-danger" href="{{ route('plan.index') }}">Cancel</a>
            <button type="submit" class="btn btn-success">Update</button>

        </form>
    </div>
@endsection
