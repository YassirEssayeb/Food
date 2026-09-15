<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Luxe Burger') - Fast & Flavorful</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800;900&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS (for grid/utility) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=4.0">
    
    <!-- 3D Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/3d-theme.css') }}?v=2.0">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @yield('styles')
</head>
<body>

    <!-- 3D Canvas Container -->
    <div id="three-canvas"></div>

    <!-- Ambient glow orbs -->
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>
    <div class="glow-orb glow-orb-3"></div>

    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-burger">
            <div class="preloader-bun-top"></div>
            <div class="preloader-patty"></div>
            <div class="preloader-bun-bottom"></div>
        </div>
        <div class="preloader-logo">LUXE BURGER</div>
        <div class="preloader-bar-container">
            <div class="preloader-bar"></div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand logo" href="{{ route('home') }}">LUXE <span style="color: #FFB703;">BURGER</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('menu') ? 'active' : '' }}" href="{{ route('menu') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('reservation') ? 'active' : '' }}" href="{{ route('reservation') }}">Reservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5 style="color: #FFB703;" class="mb-3">LUXE BURGER</h5>
                    <p>Serving the freshest, boldest burgers in town since 2010. Fast food, professional quality.</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="gold-text mb-3">Opening Hours</h5>
                    <ul class="list-unstyled">
                        <li>Mon - Thu: 5:00 PM - 10:00 PM</li>
                        <li>Fri - Sat: 5:00 PM - 11:00 PM</li>
                        <li>Sun: 12:00 PM - 9:00 PM</li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="gold-text mb-3">Contact Us</h5>
                    <p>123 Gourmet Ave, Food City<br>
                    Phone: (555) LUXE-001<br>
                    Email: info@luxedining.com</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="gold-text mb-3">Write a Review</h5>
                    <form id="footerReviewForm">
                        <select class="form-control form-control-sm mb-2" name="menu_item_name" required>
                            <option value="">Select an item</option>
                            @foreach(\App\Models\MenuItem::pluck('name') as $itemName)
                                <option value="{{ $itemName }}">{{ $itemName }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control form-control-sm mb-2" name="user_name" placeholder="Your Name" required>
                        <textarea class="form-control form-control-sm mb-2" name="comment" placeholder="Your review..." rows="2" required></textarea>
                        <button type="submit" class="btn btn-gold btn-sm w-100">
                            <i class="fas fa-paper-plane me-1"></i>Submit Review
                        </button>
                    </form>
                    <div id="footerReviewSuccess" class="alert alert-success py-1 mt-2 small" style="display:none">
                        <i class="fas fa-check-circle me-1"></i>Thanks for your review!
                    </div>
                    <div id="footerReviewError" class="alert alert-danger py-1 mt-2 small" style="display:none"></div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; <span id="footer-year">{{ date('Y') }} Luxe Burger. All rights reserved.</span></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-in-out',
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var reviewForm = document.getElementById('footerReviewForm');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    var formData = new FormData(form);
                    fetch('{{ route("review.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data.success) {
                            document.getElementById('footerReviewSuccess').style.display = 'block';
                            document.getElementById('footerReviewError').style.display = 'none';
                            form.reset();
                            setTimeout(function() {
                                document.getElementById('footerReviewSuccess').style.display = 'none';
                            }, 3000);
                        } else {
                            document.getElementById('footerReviewError').textContent = data.message || 'Something went wrong.';
                            document.getElementById('footerReviewError').style.display = 'block';
                        }
                    })
                    .catch(function() {
                        document.getElementById('footerReviewError').textContent = 'Network error. Please try again.';
                        document.getElementById('footerReviewError').style.display = 'block';
                    });
                });
            }
        });
    </script>

    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    
    <!-- Custom Animation JS -->
    <script src="{{ asset('js/app.js') }}?v=4.0"></script>
    
    @yield('scripts')
</body>
</html>
