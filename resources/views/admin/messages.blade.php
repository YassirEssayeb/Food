@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Messages</h1>
</div>

<div class="row">
    @forelse($messages as $message)
    <div class="col-md-6 mb-4">
        <div class="card {{ $message->is_read ? '' : 'border-primary' }}">
            <div class="card-header d-flex justify-content-between">
                <span><strong>From:</strong> {{ $message->name }} ({{ $message->email }})</span>
                <span class="text-muted">{{ $message->created_at->format('M d, Y H:i') }}</span>
            </div>
            <div class="card-body">
                <h5 class="card-title">Subject: {{ $message->subject ?: '(No Subject)' }}</h5>
                <p class="card-text">{{ $message->message }}</p>
                @if(!$message->is_read)
                    <form action="{{ route('admin.messages.read', $message->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-check me-1"></i>Mark as Read
                        </button>
                    </form>
                @else
                    <span class="badge bg-success mt-2"><i class="fas fa-check me-1"></i>Read</span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="lead">No messages found.</p>
    </div>
    @endforelse
</div>
@endsection
