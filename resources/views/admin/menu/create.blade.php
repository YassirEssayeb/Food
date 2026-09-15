@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Menu Item</h1>
    <a href="{{ route('menu-items.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to Menu
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('menu-items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select a category</option>
                        <option value="Appetizers" {{ old('category') == 'Appetizers' ? 'selected' : '' }}>Appetizers</option>
                        <option value="Main Course" {{ old('category') == 'Main Course' ? 'selected' : '' }}>Main Course</option>
                        <option value="Desserts" {{ old('category') == 'Desserts' ? 'selected' : '' }}>Desserts</option>
                        <option value="Drinks" {{ old('category') == 'Drinks' ? 'selected' : '' }}>Drinks</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_special" name="is_special" {{ old('is_special') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_special">Mark as Daily Special</label>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Save Menu Item</button>
        </form>
    </div>
</div>
@endsection
