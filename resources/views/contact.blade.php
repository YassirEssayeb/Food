@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <section class="section-padding page-header bg-dark text-white text-center" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="container py-5" data-aos="zoom-in">
            <h1 class="display-3 accent-text fw-bold page-header-title">CONTACT US</h1>
            <p class="lead italic page-header-subtitle">We're Here to Help</p>
        </div>
    </section>

    <section class="section-padding bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mb-5 mb-md-0" data-aos="fade-right">
                    <h2 class="section-title text-start">Get In Touch</h2>
                    <p class="mb-5 lead">Have questions about our menu, special events, or private dining? Our team is dedicated to providing you with the best experience.</p>
                    
                    <div class="d-flex mb-4 align-items-center contact-info-item">
                        <div class="gold-text me-4"><i class="fas fa-map-marker-alt fa-2x"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Our Location</h5>
                            <p class="mb-0">123 Gourmet Ave, Food City, FC 12345</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4 align-items-center contact-info-item">
                        <div class="gold-text me-4"><i class="fas fa-phone fa-2x"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Phone</h5>
                            <p class="mb-0">(555) LUXE-001</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4 align-items-center contact-info-item">
                        <div class="gold-text me-4"><i class="fas fa-envelope fa-2x"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Email</h5>
                            <p class="mb-0">info@luxedining.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7" data-aos="fade-left">
                    <div class="card p-4 p-md-5 shadow-lg border-0 form-card">
                        <h3 class="mb-4">Send us a Message</h3>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label text-uppercase small letter-spacing-1 fw-bold">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label text-uppercase small letter-spacing-1 fw-bold">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="subject" class="form-label text-uppercase small letter-spacing-1 fw-bold">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="What is this about?">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label text-uppercase small letter-spacing-1 fw-bold">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="6" placeholder="How can we help you today?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-gold w-100 py-3 shadow">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
