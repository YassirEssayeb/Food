@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reservations</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Customer</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->date }} at {{ $reservation->time }}</td>
                        <td>
                            <strong>{{ $reservation->name }}</strong><br>
                            <small>{{ $reservation->email }} | {{ $reservation->phone }}</small>
                        </td>
                        <td>{{ $reservation->party_size }}</td>
                        <td>
                            <span class="badge bg-{{ $reservation->status == 'confirmed' ? 'success' : ($reservation->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.reservations.status', $reservation->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-sm btn-success" {{ $reservation->status == 'confirmed' ? 'disabled' : '' }}>Confirm</button>
                            </form>
                            <form action="{{ route('admin.reservations.status', $reservation->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-sm btn-danger" {{ $reservation->status == 'cancelled' ? 'disabled' : '' }}>Cancel</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No reservations found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
