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
                        style="position: absolute; top: 20px; left: 0; width: 33%; height: 3px; background-color: #ff6b6b; z-index: 0;">
                    </div>

                    <!-- Step 1 - Cart -->
                    <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background-color: #4caf50; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            ✓</div>
                        <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #999;">CART</span>
                    </div>

                    <!-- Step 2 - Payment (Active) -->
                    <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                        <div
                            style="width: 40px; height: 40px; border-radius: 50%; background-color: #ff6b6b; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);">
                            2</div>
                        <span
                            style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #ff6b6b;">PAYMENT</span>
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

            <!-- Notifications -->
            @if (session('success'))
                <div
                    style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Main Content -->
            <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem;">

                <!-- Left Column - Billing Details -->
                <div
                    style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem;">
                    <h3 style="margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 600; color: #333;">Billing Details</h3>
                    <!-- Voucher Form -->
                    <form action="{{ route('order.applyVoucher') }}" method="POST">
                        @csrf
                        <div style="display: flex; gap: 0.5rem;">
                            @php
                                $lastUsedCode = session('last_applied_voucher_code');
                            @endphp

                            <select name="voucher_code" required
                                style="flex: 1; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.875rem; background-color: #f8f9fa;">
                                <option value="">-- Select Voucher --</option>
                                @foreach ($availableVouchers as $v)
                                    <option value="{{ $v->code }}" {{ $lastUsedCode === $v->code ? 'selected' : '' }}>
                                        {{ $v->code }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                style="padding: 0.75rem 1.5rem; background-color: #b80989; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-size: 0.875rem; font-weight: 600; transition: all 0.2s; white-space: nowrap;">
                                Gunakan
                            </button>
                        </div>
                    </form>
                    <br>

                    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data"
                        id="checkout-form">
                        @csrf

                        <!-- Customer Name -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">CUSTOMER
                                NAME</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name ?? '' }}" readonly
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; background-color: #f8f9fa; color: #666; font-size: 0.95rem;">
                        </div>

                        <!-- Provinsi -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">PROVINSI</label>
                            <select name="provinsi_id" id="provinsi" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.95rem; cursor: pointer; background-color: white;">
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                            <input type="hidden" name="provinsi_name" id="provinsi_name">
                        </div>

                        <!-- Kabupaten -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">KABUPATEN/KOTA</label>
                            <select name="kabupaten_id" id="kabupaten" required disabled
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.95rem; cursor: pointer; background-color: #f8f9fa;">
                                <option value="">-- Pilih Kabupaten --</option>
                            </select>
                            <input type="hidden" name="kabupaten_name" id="kabupaten_name">
                        </div>

                        <!-- Kecamatan -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">KECAMATAN</label>
                            <select name="kecamatan_id" id="kecamatan" required disabled
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.95rem; cursor: pointer; background-color: #f8f9fa;">
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                            <input type="hidden" name="kecamatan_name" id="kecamatan_name">
                        </div>

                        <!-- Desa -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">DESA/KELURAHAN</label>
                            <select name="desa_id" id="desa" required disabled
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.95rem; cursor: pointer; background-color: #f8f9fa;">
                                <option value="">-- Pilih Desa --</option>
                            </select>
                            <input type="hidden" name="desa_name" id="desa_name">
                        </div>

                        <!-- Address Detail -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">DETAIL
                                ADDRESS (RT/RW, No. Rumah, dll)</label>
                            <textarea name="address" id="address" rows="4" required placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 05"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.95rem; resize: vertical;">{{ $address->address ?? Auth::user()->alamat }}</textarea>
                        </div>

                        <!-- Note -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">NOTE
                                (OPTIONAL)</label>
                            <textarea name="note" id="note" rows="3"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.95rem; resize: vertical;"
                                placeholder="Add delivery notes..."></textarea>
                        </div>

                        <!-- Payment Method -->
                        <div style="margin-bottom: 1.5rem;">
                            <label
                                style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333; font-size: 0.875rem;">PAYMENT
                                METHOD</label>
                            <select name="payment_method" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.95rem; cursor: pointer;">
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="e_wallet">E-Wallet</option>
                            </select>
                        </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div>
                    <div
                        style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem; position: sticky; top: 2rem;">

                        <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem; font-weight: 600; color: #333;">Order Summary
                        </h3>
                        <p style="margin: 0 0 2rem 0; font-size: 0.875rem; color: #999;">Review your items before checkout
                        </p>

                        <!-- Items List -->
                        <div
                            style="border-top: 2px solid #f0f0f0; padding-top: 1.5rem; margin-bottom: 1.5rem; max-height: 250px; overflow-y: auto;">
                            @foreach ($cartItems->filter(fn($item) => $selectedItems->contains($item->id)) as $item)
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding: 0.75rem; background-color: #f8f9fa; border-radius: 0.5rem;">
                                    <div style="flex: 1;">
                                        @if ($item->product)
                                            <span style="font-size: 0.875rem; color: #666;">{{ $item->quantity }}x</span>
                                            <span
                                                style="font-size: 0.95rem; color: #333; margin-left: 0.5rem;">{{ Str::limit($item->product->name, 25) }}</span>
                                        @else
                                            <span style="color: #f44336; font-size: 0.875rem;">Item not found</span>
                                        @endif
                                    </div>
                                    <div style="font-weight: 600; color: #333; white-space: nowrap; margin-left: 0.5rem;">
                                        @if ($item->product)
                                            @if ($item->product->discount && $item->product->discount->status === 'active')
                                                Rp{{ number_format($item->product->discount->final_price * $item->quantity, 0, ',', '.') }}
                                            @else
                                                Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            @endif
                                        @else
                                            Rp0
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>




                        @php

                            $ongkirCost = session('ongkir.cost', 0);
                            $total = $cartItems
                                ->filter(fn($item) => $selectedItems->contains($item->id))
                                ->sum(function ($item) {
                                    if ($item->product) {
                                        if ($item->product->discount && $item->product->discount->status === 'active') {
                                            return $item->product->discount->final_price * $item->quantity;
                                        }
                                        return $item->product->price * $item->quantity;
                                    }
                                    return 0;
                                });

                            $voucher = session('applied_voucher');
                            $voucherDiscount = 0;

                            if ($voucher) {
                                if ($voucher['discount_type'] === 'percent') {
                                    $voucherDiscount = ($total + $ongkirCost) * ($voucher['discount_value'] / 100);
                                } else {
                                    $voucherDiscount = $voucher['discount_value'];
                                }
                            }

                            $discountedTotal = max($total + $ongkirCost - $voucherDiscount, 0);
                        @endphp



                        <!-- Cost Breakdown -->
                        <div style="border-top: 1px solid #f0f0f0; padding-top: 1rem; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                                <span style="font-size: 0.875rem; color: #666;">Subtotal</span>
                                <span
                                    style="font-weight: 600; color: #333;">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                                <span style="font-size: 0.875rem; color: #666;">Shipping</span>
                                @php
                                    $ongkirCost = session('ongkir.cost', 0);
                                @endphp
                                <span hidden
                                    style="font-weight: 600; color: #333;">Rp{{ number_format($ongkirCost, 0, ',', '.') }}</span>
                                <span  id="shipping-cost">Rp0</span>
                            </div>
                            @if ($voucher)
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                                    <span style="font-size: 0.875rem; color: #4caf50;">Voucher
                                        ({{ $voucher['code'] }})</span>
                                    <span style="font-weight: 600; color: #4caf50;">-
                                        Rp{{ number_format($voucherDiscount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Total -->
                        <div style="border-top: 2px solid #f0f0f0; padding-top: 1rem; margin-bottom: 1.5rem;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span
                                    style="font-size: 1rem; font-weight: 600; color: #333; text-transform: uppercase; letter-spacing: 0.5px;">Total</span>
                                <span id="discounted-total"
                                    style="font-size: 1.5rem; font-weight: 700; color: #333;">Rp{{ number_format($discountedTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <input type="hidden" id="points-used" name="points_used" value="0">
                        <input type="hidden" id="discounted_total" name="discounted_total"
                            value="{{ $discountedTotal }}">

                        <!-- Place Order Button -->
                        <button type="submit"
                            style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; border: none; border-radius: 2rem; font-weight: 600; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3); transition: all 0.3s; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem;">
                            PLACE ORDER
                        </button>
                        </form>



                    </div>
                </div>

            </div>

            <!-- Back to Cart Link -->
            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ route('cart.index') }}"
                    style="color: #666; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Cart
                </a>
            </div>

        </div>
    </div>

    <script>
        // Wilayah Selection Script
        document.addEventListener('DOMContentLoaded', function() {
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten');
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

            // Load Provinsi
            fetch('/wilayah/provinsi')
                .then(response => response.json())
                .then(data => {
                    data.forEach(prov => {
                        const option = document.createElement('option');
                        option.value = prov.id;
                        option.textContent = prov.name;
                        provinsiSelect.appendChild(option);
                    });

                    // ✅ AUTO-FILL: Load address jika ada
                    @if($address)
                        loadSavedAddress();
                    @endif
                })
                .catch(error => console.error('Error loading provinsi:', error));

            // ✅ Function untuk auto-fill address
            function loadSavedAddress() {
                const savedProvinsiId = '{{ $address->provinsi_id ?? '' }}';
                const savedKabupatenId = '{{ $address->kabupaten_id ?? '' }}';
                const savedKecamatanId = '{{ $address->kecamatan_id ?? '' }}';
                const savedDesaId = '{{ $address->desa_id ?? '' }}';

                if (savedProvinsiId) {
                    provinsiSelect.value = savedProvinsiId;
                    document.getElementById('provinsi_name').value = '{{ $address->provinsi_name ?? '' }}';
                    
                    // Load Kabupaten
                    kabupatenSelect.disabled = false;
                    kabupatenSelect.innerHTML = '<option value="">Loading...</option>';
                    
                    fetch(`/wilayah/kabupaten/${savedProvinsiId}`)
                        .then(response => response.json())
                        .then(data => {
                            kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                            data.forEach(kab => {
                                const option = document.createElement('option');
                                option.value = kab.id;
                                option.textContent = kab.name;
                                kabupatenSelect.appendChild(option);
                            });

                            if (savedKabupatenId) {
                                kabupatenSelect.value = savedKabupatenId;
                                document.getElementById('kabupaten_name').value = '{{ $address->kabupaten_name ?? '' }}';
                                
                                // Load Kecamatan
                                kecamatanSelect.disabled = false;
                                kecamatanSelect.innerHTML = '<option value="">Loading...</option>';
                                
                                fetch(`/wilayah/kecamatan/${savedKabupatenId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                                        data.forEach(kec => {
                                            const option = document.createElement('option');
                                            option.value = kec.id;
                                            option.textContent = kec.name;
                                            kecamatanSelect.appendChild(option);
                                        });

                                        if (savedKecamatanId) {
                                            kecamatanSelect.value = savedKecamatanId;
                                            document.getElementById('kecamatan_name').value = '{{ $address->kecamatan_name ?? '' }}';
                                            
                                            // Trigger untuk generate ongkir
                                            const randomOngkir = Math.floor(Math.random() * (15000 - 10000 + 1)) + 10000;
                                            const shippingElement = document.getElementById('shipping-cost');
                                            if (shippingElement) {
                                                shippingElement.textContent = 'Rp' + randomOngkir.toLocaleString('id-ID');
                                            }

                                            let ongkirInput = document.getElementById('ongkir_cost');
                                            if (!ongkirInput) {
                                                ongkirInput = document.createElement('input');
                                                ongkirInput.type = 'hidden';
                                                ongkirInput.id = 'ongkir_cost';
                                                ongkirInput.name = 'shipping_cost';
                                                document.body.appendChild(ongkirInput);
                                            }
                                            ongkirInput.value = randomOngkir;

                                            fetch('{{ route('setOngkir') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ cost: randomOngkir })
                                            });
                                            
                                            // Load Desa
                                            desaSelect.disabled = false;
                                            desaSelect.innerHTML = '<option value="">Loading...</option>';
                                            
                                            fetch(`/wilayah/desa/${savedKecamatanId}`)
                                                .then(response => response.json())
                                                .then(data => {
                                                    desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
                                                    data.forEach(desa => {
                                                        const option = document.createElement('option');
                                                        option.value = desa.id;
                                                        option.textContent = desa.name;
                                                        desaSelect.appendChild(option);
                                                    });

                                                    if (savedDesaId) {
                                                        desaSelect.value = savedDesaId;
                                                        document.getElementById('desa_name').value = '{{ $address->desa_name ?? '' }}';
                                                    }
                                                });
                                        }
                                    });
                            }
                        });
                }
            }

            // Provinsi Change Event
            provinsiSelect.addEventListener('change', function() {
                const provinsiId = this.value;
                const provinsiName = this.options[this.selectedIndex].text;

                // Set hidden input untuk provinsi name
                if (provinsiId && provinsiName !== '-- Pilih Provinsi --') {
                    document.getElementById('provinsi_name').value = provinsiName;
                } else {
                    document.getElementById('provinsi_name').value = '';
                }

                // Reset dependent selects
                kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';

                // Reset hidden inputs
                document.getElementById('kabupaten_name').value = '';
                document.getElementById('kecamatan_name').value = '';
                document.getElementById('desa_name').value = '';

                kecamatanSelect.disabled = true;
                desaSelect.disabled = true;

                if (provinsiId) {
                    kabupatenSelect.disabled = false;
                    kabupatenSelect.innerHTML = '<option value="">Loading...</option>';

                    fetch(`/wilayah/kabupaten/${provinsiId}`)
                        .then(response => response.json())
                        .then(data => {
                            kabupatenSelect.innerHTML =
                                '<option value="">-- Pilih Kabupaten --</option>';
                            data.forEach(kab => {
                                const option = document.createElement('option');
                                option.value = kab.id;
                                option.textContent = kab.name;
                                kabupatenSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading kabupaten:', error);
                            kabupatenSelect.innerHTML =
                                '<option value="">-- Error loading data --</option>';
                        });
                } else {
                    kabupatenSelect.disabled = true;
                }
            });

            // Kabupaten Change Event
            kabupatenSelect.addEventListener('change', function() {
                const kabupatenId = this.value;
                const kabupatenName = this.options[this.selectedIndex].text;

                // Set hidden input untuk kabupaten name
                if (kabupatenId && kabupatenName !== '-- Pilih Kabupaten --' && kabupatenName !==
                    'Loading...') {
                    document.getElementById('kabupaten_name').value = kabupatenName;
                } else {
                    document.getElementById('kabupaten_name').value = '';
                }

                // Reset dependent selects
                kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';

                // Reset hidden inputs
                document.getElementById('kecamatan_name').value = '';
                document.getElementById('desa_name').value = '';

                desaSelect.disabled = true;

                if (kabupatenId) {
                    kecamatanSelect.disabled = false;
                    kecamatanSelect.innerHTML = '<option value="">Loading...</option>';

                    fetch(`/wilayah/kecamatan/${kabupatenId}`)
                        .then(response => response.json())
                        .then(data => {
                            kecamatanSelect.innerHTML =
                                '<option value="">-- Pilih Kecamatan --</option>';
                            data.forEach(kec => {
                                const option = document.createElement('option');
                                option.value = kec.id;
                                option.textContent = kec.name;
                                kecamatanSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading kecamatan:', error);
                            kecamatanSelect.innerHTML =
                                '<option value="">-- Error loading data --</option>';
                        });
                } else {
                    kecamatanSelect.disabled = true;
                }
            });
            

            // Kecamatan Change Event
            kecamatanSelect.addEventListener('change', function() {
                const kecamatanId = this.value;
                const kecamatanName = this.options[this.selectedIndex].text;

                // Set hidden input untuk kecamatan name
                if (kecamatanId && kecamatanName !== '-- Pilih Kecamatan --' && kecamatanName !==
                    'Loading...') {
                    document.getElementById('kecamatan_name').value = kecamatanName;
                } else {
                    document.getElementById('kecamatan_name').value = '';
                }

                // Reset desa
                desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';

                // ✅ Logika random ongkir 10.000 – 15.000
                if (kecamatanId) {
                    const randomOngkir = Math.floor(Math.random() * (15000 - 10000 + 1)) + 10000;

                    // Tampilkan ke elemen Shipping
                    const shippingElement = document.getElementById('shipping-cost');
                    if (shippingElement) {
                        shippingElement.textContent = 'Rp' + randomOngkir.toLocaleString('id-ID');
                    }

                    // Simpan ke input hidden (kalau mau dikirim ke form)
                    let ongkirInput = document.getElementById('ongkir_cost');
                    if (!ongkirInput) {
                        ongkirInput = document.createElement('input');
                        ongkirInput.type = 'hidden';
                        ongkirInput.id = 'ongkir_cost';
                        ongkirInput.name = 'shipping_cost';
                        document.body.appendChild(ongkirInput);
                    }
                    ongkirInput.value = randomOngkir;

                    // ✅ Kirim ke backend agar tersimpan di session
                    fetch('{{ route('setOngkir') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                cost: randomOngkir
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                console.log('✅ Ongkir tersimpan di session:', data.cost);
                            }
                        })
                        .catch(err => console.error('❌ Gagal menyimpan ongkir:', err));


                } else {
                    // Jika tidak ada kecamatan yang dipilih
                    const shippingElement = document.getElementById('shipping-cost');
                    if (shippingElement) {
                        shippingElement.textContent = 'Rp0';
                    }

                    // Reset session ongkir ke 0
                    fetch('{{ route('setOngkir') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cost: 0
                        })
                    });
                }

                // Reset hidden input desa
                document.getElementById('desa_name').value = '';

                if (kecamatanId) {
                    desaSelect.disabled = false;
                    desaSelect.innerHTML = '<option value="">Loading...</option>';

                    fetch(`/wilayah/desa/${kecamatanId}`)
                        .then(response => response.json())
                        .then(data => {
                            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
                            data.forEach(desa => {
                                const option = document.createElement('option');
                                option.value = desa.id;
                                option.textContent = desa.name;
                                desaSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading desa:', error);
                            desaSelect.innerHTML = '<option value="">-- Error loading data --</option>';
                        });
                } else {
                    desaSelect.disabled = true;
                }
            });


            // Desa Change Event
            desaSelect.addEventListener('change', function() {
                const desaId = this.value;
                const desaName = this.options[this.selectedIndex].text;

                // Set hidden input untuk desa name
                if (desaId && desaName !== '-- Pilih Desa --' && desaName !== 'Loading...') {
                    document.getElementById('desa_name').value = desaName;
                } else {
                    document.getElementById('desa_name').value = '';
                }
            });
        });

        // Price calculation
        let totalPrice = {{ $total }};
        let pointsUsed = 0;


        let voucherDiscount = {{ $voucherDiscount ?? 0 }};

        function calculateDiscountedPrice() {
            let discountedPrice = totalPrice + shippingCost - pointsUsed - voucherDiscount;
            if (discountedPrice < 0) discountedPrice = 0;
            document.getElementById("discounted-total").textContent = 'Rp' + discountedPrice.toLocaleString('id-ID');
            document.getElementById("discounted_total").value = discountedPrice;
        }

        calculateDiscountedPrice();
    </script>


    <style>
        /* Hover effects */
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 107, 0.4) !important;
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        select:disabled {
            background-color: #f8f9fa !important;
            cursor: not-allowed !important;
        }

        @media (max-width: 992px) {
            div[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
            }
        }

        /* Custom scrollbar for items list */
        div[style*="overflow-y: auto"]::-webkit-scrollbar {
            width: 6px;
        }

        div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb:hover {
            background: #ccc;
        }
    </style>
@endsection