@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Menu Management</h1>
    <a href="{{ route('menu-items.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Add Menu Item
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Special</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menuItems as $item)
                    <tr>
                        <td>
                            @if($item->image)
                                <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>
                            @if($item->is_special)
                                <span class="badge bg-warning text-dark">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('menu-items.edit', $item->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('menu-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No menu items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
