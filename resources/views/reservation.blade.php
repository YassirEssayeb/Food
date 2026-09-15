@extends('layouts.app')

@section('title', 'Table Reservation')

@section('content')
    <section class="section-padding page-header text-white text-center" style="background: linear-gradient(135deg, rgba(10,10,15,0.9), rgba(10,10,15,0.7)), url('https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="container py-5" data-aos="zoom-in">
            <h1 class="display-3 accent-text fw-bold page-header-title">GRAB A TABLE</h1>
            <p class="lead italic page-header-subtitle" style="color: rgba(255,255,255,0.7);">Fast Bites, Great Vibes</p>
        </div>
    </section>

    <section class="section-padding section-darker">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" data-aos="fade-up">
                    <div class="card p-4 p-md-5 shadow-lg border-0 form-card">
                        <h2 class="text-center mb-5 section-title">Book a Table</h2>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label text-uppercase small letter-spacing-1 fw-bold">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label text-uppercase small letter-spacing-1 fw-bold">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label text-uppercase small letter-spacing-1 fw-bold">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 234 567 890" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="party_size" class="form-label text-uppercase small letter-spacing-1 fw-bold">Number of Guests</label>
                                    <input type="number" class="form-control" id="party_size" name="party_size" min="1" value="{{ old('party_size', 1) }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="date" class="form-label text-uppercase small letter-spacing-1 fw-bold">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="time" class="form-label text-uppercase small letter-spacing-1 fw-bold">Time</label>
                                    <input type="time" class="form-control" id="time" name="time" value="{{ old('time') }}" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="notes" class="form-label text-uppercase small letter-spacing-1 fw-bold">Special Requests</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Any dietary requirements or special occasions?">{{ old('notes') }}</textarea>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-gold btn-lg w-100 py-3 shadow btn-shimmer">Get My Table!</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
