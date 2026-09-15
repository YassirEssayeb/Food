@extends('layouts.app')

@section('title', 'Our Exquisite Menu')

@section('content')
    <section class="section-padding page-header text-white text-center" style="background: linear-gradient(135deg, rgba(10,10,15,0.9), rgba(10,10,15,0.7)), url('https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="container py-5" data-aos="zoom-in">
            <h1 class="display-3 accent-text fw-bold page-header-title">OUR MENU</h1>
            <p class="lead italic page-header-subtitle" style="color: rgba(255,255,255,0.7);">Fast, Fresh & Seriously Flavorful</p>
        </div>
    </section>

    <section class="section-padding section-gradient">
        <div class="container">
            @forelse($menuItems as $category => $items)
                <div class="mb-5">
                    <h2 class="section-title text-start mb-5 menu-category-title" data-aos="fade-right">{{ $category }}</h2>
                    <div class="row">
                        @foreach($items as $index => $item)
                            <div class="col-lg-4 col-md-6 mb-4 tilt-wrapper" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 3 + 1) }}">
                                <div class="menu-card tilt-card" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#foodDetailModal"
                                     data-name="{{ $item->name }}"
                                     data-description="{{ $item->description }}"
                                     data-price="${{ number_format($item->price, 2) }}"
                                     data-price-value="{{ $item->price }}"
                                     data-image="{{ $item->image && !str_starts_with($item->image, 'http') ? asset('storage/' . $item->image) : ($item->image ?: 'https://via.placeholder.com/600x400?text=' . urlencode($item->name)) }}"
                                     data-category="{{ $item->category }}"
                                     data-ingredients="{{ $item->ingredients ?: 'Chef\'s secret blend of fresh ingredients.' }}"
                                     data-allergens="{{ $item->allergens ?: 'None reported.' }}">
                                    
                                    <div class="menu-card-img-container">
                                        <div class="menu-card-price">${{ number_format($item->price, 2) }}</div>
                                        <img src="{{ $item->image && !str_starts_with($item->image, 'http') ? asset('storage/' . $item->image) : ($item->image ?: 'https://via.placeholder.com/600x400?text=' . urlencode($item->name)) }}" 
                                             alt="{{ $item->name }}" 
                                             class="menu-card-img">
                                    </div>
                                    
                                    <div class="menu-card-body">
                                        <div class="menu-card-category">{{ $category }}</div>
                                        <h3 class="menu-card-title">{{ $item->name }}</h3>
                                        <p class="menu-card-description">{{ $item->description }}</p>
                                        <div class="menu-card-footer">
                                            <span class="view-details-link">Quick View <i class="fas fa-arrow-right"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-5" data-aos="fade-up">
                    <p class="lead italic" style="color: rgba(255,255,255,0.5);">Our chefs are currently refining our seasonal offerings. Please check back soon!</p>
                </div>
            @endforelse
        </div>
    </section>

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
                if (qty > 1) { qty--;
                    document.getElementById('orderQty').textContent = qty;
                    document.getElementById('orderQuantity').value = qty; }
            });
            document.getElementById('qtyPlus').addEventListener('click', function() {
                var qty = parseInt(document.getElementById('orderQty').textContent);
                if (qty < 20) { qty++;
                    document.getElementById('orderQty').textContent = qty;
                    document.getElementById('orderQuantity').value = qty; }
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
