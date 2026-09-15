@extends('layouts.app')

@section('title', 'Bold Burgers & Fast Bites')

@section('content')
    <!-- Hero Section - 3D Immersive -->
    <section class="hero hero-split" id="heroCarousel">
        <div class="hero-overlay-3d"></div>

        <div class="hero-split-inner">
            <div class="hero-text-col">
                <p class="hero-badge">Since 2010</p>
                <h1 class="hero-title">The Boldest <span class="accent-text">Burgers</span> In Town</h1>
                <p class="hero-subtitle">Fast, Fresh, and Seriously Flavorful</p>
                <div class="hero-cta">
                    <a href="{{ route('menu') }}" class="btn btn-gold me-3 btn-shimmer">Explore Menu</a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline-gold">Find a Table</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-value">100%</span>
                        <span class="hero-stat-label">Wagyu Beef</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-value">1M+</span>
                        <span class="hero-stat-label">Burgers Sold</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-value">15</span>
                        <span class="hero-stat-label">Signature Recipes</span>
                    </div>
                </div>
            </div>
            <div class="hero-burger-col"></div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section-padding section-gradient overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-5 mb-md-0" data-aos="fade-right">
                    <div class="position-relative about-gallery" id="aboutGallery">
                        <div class="about-gallery-slides">
                            <div class="about-gallery-slide active" style="background-image: url('https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');"></div>
                            <div class="about-gallery-slide" style="background-image: url('https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');"></div>
                            <div class="about-gallery-slide" style="background-image: url('https://images.unsplash.com/photo-1572490122747-3968b75cc699?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80');"></div>
                        </div>
                        <div class="about-badge position-absolute top-0 start-0 text-white fw-bold p-3" style="transform: rotate(-10deg) translate(-10px, -10px); border-radius: 10px;">HOT & FRESH</div>
                    </div>
                </div>
                <div class="col-md-6 ps-md-5" data-aos="fade-left">
                    <h2 class="section-title text-start">Our <span style="color: #E63946; -webkit-text-fill-color: #E63946;">Passion</span></h2>
                    <p class="lead fw-bold" style="color: rgba(255,255,255,0.8);">At Luxe Burger, we don't do boring. We do BIG flavors and BOLD ingredients.</p>
                    <p style="color: rgba(255,255,255,0.5);">Since 2010, we've been on a mission to redefine fast food. We use 100% premium wagyu beef, locally sourced produce, and house-made sauces that you won't find anywhere else. Every burger is built to order, ensuring maximum crunch and maximum flavor.</p>
                    <p style="color: rgba(255,255,255,0.5);">Join the flavor revolution today. Whether you're here for a quick bite or a feast with friends, we've got you covered.</p>
                    <a href="{{ route('menu') }}" class="btn btn-primary-ff mt-3">Full Menu</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Daily Specials Section -->
    <section class="section-padding section-darker">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Most <span style="color: #E63946; -webkit-text-fill-color: #E63946;">Wanted</span></h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Our most popular creations, crafted to perfection</p>
            <div class="row">
                @forelse($specials as $index => $special)
                    <div class="col-md-4 mb-4 tilt-wrapper" data-aos="zoom-in" data-aos-delay="{{ 200 * ($index + 1) }}">
                        <div class="menu-card tilt-card position-relative"
                             data-bs-toggle="modal" 
                             data-bs-target="#foodDetailModal"
                             data-name="{{ $special->name }}"
                             data-description="{{ $special->description }}"
                             data-price="${{ number_format($special->price, 2) }}"
                             data-price-value="{{ $special->price }}"
                             data-image="{{ $special->image && !str_starts_with($special->image, 'http') ? asset('storage/' . $special->image) : ($special->image ?: 'https://via.placeholder.com/600x400?text=' . urlencode($special->name)) }}"
                             data-category="{{ $special->category }}"
                             data-ingredients="{{ $special->ingredients ?: 'Chef\'s secret blend of fresh ingredients.' }}"
                             data-allergens="{{ $special->allergens ?: 'None reported.' }}">
                            
                            <div class="menu-card-img-container">
                                <div class="menu-card-price">${{ number_format($special->price, 2) }}</div>
                                @if($special->image)
                                    <img src="{{ str_starts_with($special->image, 'http') ? $special->image : asset('storage/' . $special->image) }}" class="menu-card-img" alt="{{ $special->name }}">
                                @else
                                    <img src="https://via.placeholder.com/400x300?text={{ $special->name }}" class="menu-card-img" alt="{{ $special->name }}">
                                @endif
                            </div>
                            <div class="menu-card-body text-center">
                                <div class="menu-card-category">{{ $special->category }}</div>
                                <h3 class="menu-card-title">{{ $special->name }}</h3>
                                <p class="text-muted small mb-0" style="color: rgba(255,255,255,0.45) !important;">{{ $special->description }}</p>
                                <div class="mt-3">
                                    <span class="view-details-link justify-content-center">Quick View <i class="fas fa-arrow-right ms-2"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p class="lead">Getting the grill hot! Check our full menu.</p>
                        <a href="{{ route('menu') }}" class="btn btn-gold">Full Menu</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Customer Reviews -->
    @if($reviews->count())
    <section class="section-padding section-gradient">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">What Our <span style="color: #E63946; -webkit-text-fill-color: #E63946;">Customers</span> Say</h2>
            <div class="row">
                @foreach($reviews as $review)
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index % 3 + 1) }}">
                        <div class="public-review-card">
                            <div class="public-review-header">
                                <strong>{{ $review->user_name }}</strong>
                                @if($review->rating)
                                    <span class="ms-2">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            <i class="fas fa-star text-warning" style="font-size:0.7rem"></i>
                                        @endfor
                                    </span>
                                @endif
                            </div>
                            <div class="public-review-item">
                                <span class="badge bg-warning text-dark me-1">{{ $review->menu_item_name }}</span>
                            </div>
                            <p class="public-review-comment">{{ $review->comment }}</p>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Food Detail Modal -->
    <div class="modal fade" id="foodDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-0 overflow-hidden">
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>

                <div class="row g-0">
                    <div class="col-md-5">
                        <div class="modal-hero">
                            <img src="" id="modalImage" alt="Food Item" class="modal-hero-img">
                            <div class="modal-hero-overlay"></div>
                            <div class="modal-hero-badge" id="modalCategory">Category</div>
                            <div class="modal-hero-price" id="modalPriceBadge">$0.00</div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="modal-body-content">
                            <div class="modal-rating mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                                <span class="ms-2 fw-bold">4.8</span>
                                <span class="text-muted small">(128 reviews)</span>
                            </div>

                            <h2 class="modal-title-custom fw-bold" id="modalName"></h2>

                            <div class="modal-info-item">
                                <span class="modal-info-label"><i class="fas fa-book-open me-2"></i>The Flavor Story</span>
                                <p class="modal-info-text lead" id="modalDescription"></p>
                            </div>

                            <div class="modal-info-item">
                                <span class="modal-info-label"><i class="fas fa-carrot me-2"></i>What's Inside</span>
                                <div class="d-flex flex-wrap gap-1" id="modalIngredients"></div>
                            </div>

                            <hr>

                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <div class="modal-info-label mb-1"><i class="fas fa-exclamation-triangle me-1"></i>Allergens</div>
                                    <div class="d-flex flex-wrap gap-1" id="modalAllergens"></div>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="modal-info-label mb-1">Price</div>
                                    <h3 class="modal-price-display fw-bold" id="modalPrice">$0.00</h3>
                                </div>
                            </div>

                            <hr>

                            <div class="modal-order-section">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="qty-selector">
                                        <button type="button" class="qty-btn" id="qtyMinus">−</button>
                                        <span class="qty-value" id="orderQty">1</span>
                                        <button type="button" class="qty-btn" id="qtyPlus">+</button>
                                    </div>
                                    <button class="btn btn-gold flex-fill py-2" id="orderNowBtn">
                                        <i class="fas fa-truck me-2"></i>Order for Delivery
                                    </button>
                                </div>
                                <div id="deliveryForm" class="mt-2" style="display:none">
                                    <form id="orderForm">
                                        <input type="hidden" name="menu_item_name" id="orderItemName">
                                        <input type="hidden" name="price" id="orderPrice">
                                        <input type="hidden" name="quantity" id="orderQuantity">
                                        <div class="row g-2 mb-2">
                                            <div class="col-6">
                                                <input type="text" class="form-control form-control-sm" name="customer_name" placeholder="Your Name" required>
                                            </div>
                                            <div class="col-6">
                                                <input type="email" class="form-control form-control-sm" name="customer_email" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <input type="tel" class="form-control form-control-sm mb-2" name="customer_phone" placeholder="Phone Number" required>
                                        <textarea class="form-control form-control-sm mb-2" name="delivery_address" placeholder="Delivery Address" rows="2" required></textarea>
                                        <textarea class="form-control form-control-sm mb-2" name="notes" placeholder="Extra notes (optional)" rows="1"></textarea>
                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                            <i class="fas fa-check me-1"></i>Place Order
                                        </button>
                                    </form>
                                    <div id="orderSuccess" class="alert alert-success py-2 mb-0 mt-2" style="display:none">
                                        <i class="fas fa-check-circle me-1"></i>Order placed! We'll deliver soon.
                                    </div>
                                    <div id="orderError" class="alert alert-danger py-2 mb-0 mt-2" style="display:none"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <section class="section-padding stats-section text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="200">
                    <h3 class="gold-text display-3 fw-bold shimmer"><span class="counter-value">1M+</span></h3>
                    <p class="text-uppercase fw-bold letter-spacing-2">Burgers Flipped</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="400">
                    <h3 class="gold-text display-3 fw-bold shimmer"><span class="counter-value">100%</span></h3>
                    <p class="text-uppercase fw-bold letter-spacing-2">Wagyu Beef</p>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="600">
                    <h3 class="gold-text display-3 fw-bold shimmer"><span class="counter-value">0</span></h3>
                    <p class="text-uppercase fw-bold letter-spacing-2">Boring Bites</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="section-padding text-center section-gradient">
        <div class="container" data-aos="zoom-out">
            <h2 class="mb-4 display-4 fw-bold cta-title" style="color:#fff;">Hungry Yet?</h2>
            <p class="lead mb-5 max-width-700 mx-auto fw-bold" style="color: rgba(255,255,255,0.6);">The grill is ready, the shakes are cold, and the fries are waiting. Don't keep your stomach waiting.</p>
            <a href="{{ route('reservation') }}" class="btn btn-gold btn-lg px-5 shadow-lg cta-btn btn-shimmer">Grab a Table</a>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const foodDetailModal = document.getElementById('foodDetailModal');
            if (!foodDetailModal) return;

            let currentPrice = 0;

            foodDetailModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const name = button.getAttribute('data-name');
                const description = button.getAttribute('data-description');
                const price = button.getAttribute('data-price');
                const image = button.getAttribute('data-image');
                const category = button.getAttribute('data-category');
                const ingredients = button.getAttribute('data-ingredients');
                const allergens = button.getAttribute('data-allergens');

                currentPrice = parseFloat(button.getAttribute('data-price-value')) || 0;

                document.getElementById('modalName').textContent = name;
                document.getElementById('modalDescription').textContent = description;
                document.getElementById('modalPrice').textContent = price;
                document.getElementById('modalPriceBadge').textContent = price;
                document.getElementById('modalImage').src = image;
                document.getElementById('modalCategory').textContent = category || 'Special';

                document.getElementById('orderItemName').value = name;
                document.getElementById('orderPrice').value = currentPrice;
                document.getElementById('orderQuantity').value = 1;
                document.getElementById('orderQty').textContent = '1';
                document.getElementById('deliveryForm').style.display = 'none';
                document.getElementById('orderSuccess').style.display = 'none';
                document.getElementById('orderError').style.display = 'none';
                document.getElementById('orderForm').reset();

                const ingredientsContainer = document.getElementById('modalIngredients');
                ingredientsContainer.innerHTML = '';
                if (ingredients) {
                    ingredients.split(',').forEach(function(item) {
                        const chip = document.createElement('span');
                        chip.className = 'ingredient-chip';
                        chip.textContent = item.trim();
                        ingredientsContainer.appendChild(chip);
                    });
                } else {
                    const chip = document.createElement('span');
                    chip.className = 'ingredient-chip';
                    chip.textContent = 'Chef\'s secret blend';
                    ingredientsContainer.appendChild(chip);
                }

                const allergensContainer = document.getElementById('modalAllergens');
                allergensContainer.innerHTML = '';
                if (allergens && allergens !== 'None reported.') {
                    allergens.split(',').forEach(function(allergen) {
                        const badge = document.createElement('span');
                        badge.className = 'badge badge-allergen';
                        badge.textContent = allergen.trim();
                        allergensContainer.appendChild(badge);
                    });
                } else {
                    allergensContainer.innerHTML = '<span class="text-muted small"><i class="fas fa-check-circle text-success me-1"></i>None reported</span>';
                }
            });

            document.getElementById('qtyMinus').addEventListener('click', function() {
                var qty = parseInt(document.getElementById('orderQty').textContent);
                if (qty > 1) {
                    qty--;
                    document.getElementById('orderQty').textContent = qty;
                    document.getElementById('orderQuantity').value = qty;
                }
            });
            document.getElementById('qtyPlus').addEventListener('click', function() {
                var qty = parseInt(document.getElementById('orderQty').textContent);
                if (qty < 20) {
                    qty++;
                    document.getElementById('orderQty').textContent = qty;
                    document.getElementById('orderQuantity').value = qty;
                }
            });

            document.getElementById('orderNowBtn').addEventListener('click', function() {
                var form = document.getElementById('deliveryForm');
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });

            document.getElementById('orderForm').addEventListener('submit', function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);

                fetch('{{ route("order.store") }}', {
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
                        document.getElementById('orderSuccess').style.display = 'block';
                        document.getElementById('orderError').style.display = 'none';
                        form.reset();
                        document.getElementById('orderQty').textContent = '1';
                        document.getElementById('orderQuantity').value = 1;
                        setTimeout(function() {
                            document.getElementById('deliveryForm').style.display = 'none';
                            document.getElementById('orderSuccess').style.display = 'none';
                        }, 3000);
                    } else {
                        document.getElementById('orderError').textContent = data.message || 'Something went wrong.';
                        document.getElementById('orderError').style.display = 'block';
                    }
                })
                .catch(function() {
                    document.getElementById('orderError').textContent = 'Network error. Please try again.';
                    document.getElementById('orderError').style.display = 'block';
                });
            });
        });
    </script>
@endsection
