@extends('layouts.app')

@section('content')
    <div style="background-color: #f8f9fa; min-height: 100vh; padding: 2rem 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">

            <!-- Progress Stepper -->
            <div style="margin-bottom: 3rem;">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; position: relative; max-width: 800px; margin: 0 auto;">
                    <!-- Line Background -->
                    <div
                        style="position: absolute; top: 20px; left: 0; right: 0; height: 3px; background-color: #e0e0e0; z-index: 0;">
                    </div>
                    <div
                        style="position: absolute; top: 20px; left: 0; width: 0%; height: 3px; background-color: #ff6b6b; z-index: 0;">
                    </div>

                    <!-- Step 1 - Cart (Active) -->
                    <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background-color: #ff6b6b; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);">
                            1</div>
                        <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #ff6b6b;">CART</span>
                    </div>

                    <!-- Step 2 - Payment -->
                    <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background-color: #ffd93d; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            2</div>
                        <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #999;">PAYMENT</span>
                    </div>

                    <!-- Step 3 - Delivery -->
                    <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background-color: #ffd93d; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            3</div>
                        <span
                            style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #999;">DELIVERY</span>
                    </div>

                    <!-- Step 4 - Done -->
                    <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background-color: #ffd93d; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            4</div>
                        <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #999;">DONE</span>
                    </div>
                </div>
            </div>

            <!-- Cart Content -->
            <div
                style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem;">

                <!-- Header with Select All -->
                <div
                    style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; border-bottom: 2px solid #f0f0f0; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <input type="checkbox" id="selectAll"
                            style="width: 20px; height: 20px; cursor: pointer; accent-color: #ff6b6b;">
                        <label for="selectAll"
                            style="margin: 0; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer;">SELECT
                            ALL</label>
                    </div>
                    <div style="display: flex; gap: 8rem;">
                        <h5
                            style="margin: 0; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            PRICE</h5>
                        <h5
                            style="margin: 0; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            QUANTITY</h5>
                        <h5
                            style="margin: 0; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            TOTAL</h5>
                    </div>
                </div>

                <!-- Cart Items -->
                <form action="{{ route('checkout.selected') }}" method="POST" id="cartForm">
                    @csrf

                    @foreach ($cartItems as $item)
                        @php
                            $product = $item->product;
                            $variant = $item->variant;
                            $price = $product?->price ?? 0;
                            $name = $product?->name ?? 'Produk tidak ditemukan';
                            $image = $product?->image ?? 'images/default.jpg';
                            $size = $variant?->size ?? '-';
                            $color = $variant?->color ?? '-';
                            $subtotal = $item->quantity * $price;
                        @endphp

                        <div class="cart-item"
                            style="display: flex; align-items: center; justify-content: space-between; padding: 1.5rem 0; border-bottom: 1px solid #f5f5f5;">

                            <!-- Checkbox -->
                            <div style="width: 50px; display: flex; justify-content: center;">
                                <input type="checkbox" class="item-checkbox" name="selected_items[]"
                                    value="{{ $item->id }}" data-subtotal="{{ $subtotal }}"
                                    data-item-id="{{ $item->id }}"
                                    style="width: 20px; height: 20px; cursor: pointer; accent-color: #ff6b6b;">
                            </div>

                            <!-- Item Info -->
                            <div style="display: flex; align-items: center; gap: 1.5rem; flex: 1;">
                                <!-- Image -->
                                <div
                                    style="width: 100px; height: 100px; border-radius: 0.75rem; overflow: hidden; background-color: #f8f9fa; flex-shrink: 0;">
                                    <img src="/images/{{ $image }}" alt="{{ $name }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                                <!-- Product Details -->
                                <div style="flex: 1;">
                                    <h6 style="margin: 0 0 0.5rem 0; font-weight: 600; color: #333; font-size: 1rem;">
                                        {{ $name }}</h6>
                                    <div style="display: flex; gap: 1rem; align-items: center;">
                                        <span style="font-size: 0.875rem; color: #666;">SIZE <span
                                                style="color: #333; font-weight: 600;">{{ $size }}</span></span>
                                        <span style="font-size: 0.875rem; color: #666;">COLOR <span
                                                style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: {{ strtolower($color) == 'merah' ? '#e74c3c' : (strtolower($color) == 'biru' ? '#3498db' : (strtolower($color) == 'hijau' ? '#2ecc71' : '#95a5a6')) }}; vertical-align: middle; margin-left: 4px; border: 2px solid white; box-shadow: 0 0 0 1px #ddd;"></span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Price -->
                            <div style="width: 120px; text-align: center;">
                                <span style="font-weight: 600; color: #333; font-size: 1rem;">Rp
                                    {{ number_format($price, 0, ',', '.') }}</span>
                            </div>

                            <!-- Quantity Controls -->
                            <div style="width: 180px; display: flex; align-items: center; justify-content: center;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="number" name="quantity_{{ $item->id }}" value="{{ $item->quantity }}" min="1"
                                        class="quantity-input" data-item-id="{{ $item->id }}"
                                        data-price="{{ $price }}"
                                        style="width: 60px; height: 32px; text-align: center; border: 1px solid #ddd; border-radius: 4px; font-weight: 600; color: #333; font-size: 0.95rem;">
                                    <button type="button" class="update-quantity-btn" data-item-id="{{ $item->id }}"
                                        style="padding: 0.6rem 1.25rem; 
         background-color: #ff6b6b; 
         color: white; 
         border: none; 
         border-radius: 6px; 
         font-size: 1rem; 
         font-weight: 600; 
         cursor: pointer; 
         transition: all 0.2s;">
                                        Update
                                    </button>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div style="width: 130px; text-align: center;">
                                <span class="item-subtotal" data-item-id="{{ $item->id }}"
                                    style="font-weight: 700; color: #333; font-size: 1.1rem;">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <!-- Delete Button -->
                            <div style="width: 40px; text-align: center;">
                                <button type="button" class="delete-item" data-item-id="{{ $item->id }}"
                                    style="width: 32px; height: 32px; border: none; background-color: transparent; cursor: pointer; color: #999; font-size: 1.25rem; transition: all 0.2s; border-radius: 4px;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <!-- Footer Section -->
                    <div style="margin-top: 3rem; display: flex; justify-content: space-between; align-items: center;">

                        <!-- Promo Code (Left) -->
                        <div style="flex: 1; max-width: 400px;">
                            <div id="promoMessage"
                                style="margin-top: 0.5rem; font-size: 0.813rem; color: #4caf50; display: none;"></div>
                        </div>

                        <!-- Totals (Right) -->
                        <div style="text-align: right;">
                            <div style="margin-bottom: 1rem;">
                                <span
                                    style="font-size: 0.875rem; color: #666; text-transform: uppercase; letter-spacing: 0.5px;">DISCOUNT</span>
                                <span id="discountAmount"
                                    style="font-size: 1.5rem; font-weight: 700; color: #333; margin-left: 2rem;">Rp
                                    0</span>
                            </div>
                            <div style="margin-bottom: 1.5rem;">
                                <span
                                    style="font-size: 0.875rem; color: #666; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL</span>
                                <span id="totalAmount"
                                    style="font-size: 1.5rem; font-weight: 700; color: #333; margin-left: 2rem;">Rp
                                    0</span>
                            </div>
                            <button type="submit" id="checkoutBtn"
                                style="padding: 0.875rem 3rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; border: none; border-radius: 2rem; font-weight: 600; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3); transition: all 0.3s; text-transform: uppercase; letter-spacing: 0.5px;">
                                CHECK OUT
                            </button>
                        </div>
                    </div>

                </form>

            </div>

            <!-- Continue Shopping Link -->
            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ route('home.index') }}"
                    style="color: #666; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Jelajah
                </a>
            </div>

        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JavaScript for Cart Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show error alert if session error exists
            @if (session('error_cart'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error_cart') }}',
                    confirmButtonColor: '#ff6b6b'
                });
            @endif

            // Show success alert if session success exists
            @if (session('success_cart'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success_cart') }}',
                    confirmButtonColor: '#4caf50',
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            let discount = 0;
            const selectAllCheckbox = document.getElementById('selectAll');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const checkoutBtn = document.getElementById('checkoutBtn');

            // Select All functionality
            selectAllCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                calculateTotal();
            });

            // Individual checkbox change
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    calculateTotal();
                });
            });

            // Calculate total based on selected items
            function calculateTotal() {
                let total = 0;
                let hasSelectedItems = false;

                itemCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        hasSelectedItems = true;
                        const subtotal = parseFloat(checkbox.dataset.subtotal);
                        total += subtotal;
                    }
                });

                document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');

                // Enable/disable checkout button
                checkoutBtn.disabled = !hasSelectedItems;
                if (!hasSelectedItems) {
                    checkoutBtn.style.opacity = '0.5';
                    checkoutBtn.style.cursor = 'not-allowed';
                } else {
                    checkoutBtn.style.opacity = '1';
                    checkoutBtn.style.cursor = 'pointer';
                }
            }

            // Update item subtotal in UI when quantity input changes
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    const itemId = this.dataset.itemId;
                    const quantity = parseInt(this.value) || 1;
                    const price = parseFloat(this.dataset.price);
                    const subtotal = quantity * price;

                    // Update subtotal display
                    document.querySelector(`.item-subtotal[data-item-id="${itemId}"]`).textContent =
                        'Rp ' + subtotal.toLocaleString('id-ID');

                    // Update checkbox data-subtotal
                    const checkbox = document.querySelector(
                        `.item-checkbox[data-item-id="${itemId}"]`);
                    checkbox.dataset.subtotal = subtotal;

                    calculateTotal();
                });
            });

            // Update quantity button click
            document.querySelectorAll('.update-quantity-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    const quantityInput = document.querySelector(`input[name="quantity_${itemId}"]`);
                    const quantity = parseInt(quantityInput.value) || 1;

                    // Create form dynamically
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("cart.update") }}';

                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    // Add cart_id
                    const cartIdInput = document.createElement('input');
                    cartIdInput.type = 'hidden';
                    cartIdInput.name = 'cart_id';
                    cartIdInput.value = itemId;
                    form.appendChild(cartIdInput);

                    // Add quantity
                    const quantityInputHidden = document.createElement('input');
                    quantityInputHidden.type = 'hidden';
                    quantityInputHidden.name = 'quantity';
                    quantityInputHidden.value = quantity;
                    form.appendChild(quantityInputHidden);

                    // Submit form
                    document.body.appendChild(form);
                    form.submit();
                });
            });

            // Delete item
            document.querySelectorAll('.delete-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Hapus produk dari keranjang?')) {
                        const itemId = this.dataset.itemId;

                        // Create form dynamically
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("cart.delete") }}';

                        // Add CSRF token
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        form.appendChild(csrfInput);

                        // Add method DELETE
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        // Add cart_id
                        const cartIdInput = document.createElement('input');
                        cartIdInput.type = 'hidden';
                        cartIdInput.name = 'cart_id';
                        cartIdInput.value = itemId;
                        form.appendChild(cartIdInput);

                        // Submit form
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            // Form submit validation
            document.getElementById('cartForm').addEventListener('submit', function(e) {
                const hasSelectedItems = Array.from(itemCheckboxes).some(cb => cb.checked);
                if (!hasSelectedItems) {
                    e.preventDefault();
                    alert('Pilih minimal satu item untuk checkout!');
                }
            });

            // Hover effects
            document.querySelectorAll('.delete-item').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#ffebee';
                    this.style.color = '#f44336';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = 'transparent';
                    this.style.color = '#999';
                });
            });

            // Initial calculation
            calculateTotal();
        });
    </script>

    <style>
        button[type="submit"]:hover:not(:disabled),
        .update-quantity-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 107, 0.4) !important;
        }

        button[type="submit"]:active:not(:disabled),
        .update-quantity-btn:active {
            transform: translateY(0);
        }

        .cart-item:last-child {
            border-bottom: none !important;
        }
    </style>
@endsection