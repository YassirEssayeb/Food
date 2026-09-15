@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Menu Item</h1>
    <a href="{{ route('menu-items.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to Menu
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $menuItem->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select a category</option>
                        <option value="Appetizers" {{ old('category', $menuItem->category) == 'Appetizers' ? 'selected' : '' }}>Appetizers</option>
                        <option value="Main Course" {{ old('category', $menuItem->category) == 'Main Course' ? 'selected' : '' }}>Main Course</option>
                        <option value="Desserts" {{ old('category', $menuItem->category) == 'Desserts' ? 'selected' : '' }}>Desserts</option>
                        <option value="Drinks" {{ old('category', $menuItem->category) == 'Drinks' ? 'selected' : '' }}>Drinks</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $menuItem->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Image (Leave blank to keep current)</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @if($menuItem->image)
                        <div class="mt-2">
                            <small>Current Image:</small><br>
                            <img src="{{ str_starts_with($menuItem->image, 'http') ? $menuItem->image : asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" style="width: 100px;">
                        </div>
                    @endif
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $menuItem->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_special" name="is_special" {{ old('is_special', $menuItem->is_special) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_special">Mark as Daily Special</label>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Update Menu Item</button>
        </form>
    </div>
</div>
@endsection
