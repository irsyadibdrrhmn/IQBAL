@extends('layouts.app')

@section('content')
<div style="background-color: #f8f9fa; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 1rem;">
        
        <!-- Breadcrumb -->
        <div style="margin-bottom: 2rem;">
            <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #666;">
                <a href="{{ route('home.index') }}" style="color: #666; text-decoration: none; transition: color 0.2s;">Home</a>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="{{ route('home.index') }}" style="color: #666; text-decoration: none; transition: color 0.2s;">Products</a>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span style="color: #ff6b6b; font-weight: 600;">{{ $product->name }}</span>
            </nav>
        </div>

        <!-- Product Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
            
            <!-- Product Image -->
            <div style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                @if($product->discount && $product->discount->status === 'active')
                    <div style="position: absolute; top: 1.5rem; left: 1.5rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; padding: 0.5rem 1rem; border-radius: 2rem; font-weight: 700; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4); z-index: 10;">
                        SALE
                    </div>
                @endif
                @if($product->is_premium)
                    <div style="position: absolute; top: 1.5rem; right: 1.5rem; background-color: #ffd93d; color: #333; padding: 0.5rem 1rem; border-radius: 2rem; font-weight: 700; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(255, 217, 61, 0.4); z-index: 10;">
                        PREMIUM
                    </div>
                @endif
                <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                     style="max-width: 100%; max-height: 500px; object-fit: contain; border-radius: 0.75rem;">
            </div>

            <!-- Product Details -->
            <div style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem;">
                
                <!-- Category Badge -->
                <div style="margin-bottom: 1rem;">
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; background-color: #e3f2fd; color: #1976d2; border-radius: 2rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $product->category->name }}
                    </span>
                </div>

                <!-- Product Name -->
                <h1 style="margin: 0 0 1rem 0; font-size: 2rem; font-weight: 700; color: #333; line-height: 1.3;">
                    {{ $product->name }}
                </h1>

                <!-- Rating -->
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid #f0f0f0;">
                    <div style="display: flex; align-items: center; gap: 0.25rem;">
                        @php
                            $fullStars = floor($averageRating);
                            $halfStar = round($averageRating - $fullStars, 1) == 0.5;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $fullStars)
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#ffc107" stroke="#ffc107" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            @elseif ($halfStar && $i == $fullStars + 1)
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="url(#half)" stroke="#ffc107" stroke-width="2">
                                    <defs>
                                        <linearGradient id="half">
                                            <stop offset="50%" stop-color="#ffc107"/>
                                            <stop offset="50%" stop-color="transparent"/>
                                        </linearGradient>
                                    </defs>
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffc107" stroke-width="2">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span style="font-weight: 600; color: #333;">{{ number_format($averageRating, 1) }}</span>
                    <a href="#reviews-section" style="color: #666; text-decoration: none; font-size: 0.875rem; transition: color 0.2s;">
                        ({{ $totalReviews }} reviews)
                    </a>
                </div>

                <!-- Price -->
                <div style="margin-bottom: 1.5rem;">
                    @if ($product->discount && $product->discount->status === 'active')
                        <div style="display: flex; align-items: baseline; gap: 1rem;">
                            <span style="font-size: 2rem; font-weight: 700; color: #ff6b6b;">
                                Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}
                            </span>
                            <span style="font-size: 1.25rem; color: #999; text-decoration: line-through;">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
                        @php
                            $discountPercent = (($product->price - $product->discount->final_price) / $product->price) * 100;
                        @endphp
                        <div style="margin-top: 0.5rem;">
                            <span style="display: inline-block; padding: 0.375rem 0.75rem; background-color: #ffe0e0; color: #ff6b6b; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;">
                                Save {{ number_format($discountPercent, 0) }}%
                            </span>
                        </div>
                    @else
                        <span style="font-size: 2rem; font-weight: 700; color: #ff6b6b;">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding: 1rem; background-color: {{ $product->stock > 0 ? '#d4edda' : '#f8d7da' }}; border-radius: 0.75rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $product->stock > 0 ? '#28a745' : '#dc3545' }}" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    <span style="font-weight: 600; color: {{ $product->stock > 0 ? '#155724' : '#721c24' }};">
                        @if($product->stock > 0)
                            In Stock ({{ $product->stock }} available)
                        @else
                            Out of Stock
                        @endif
                    </span>
                </div>

                <!-- Description -->
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 0.875rem; font-weight: 600; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Description</h3>
                    <p style="color: #666; line-height: 1.7; margin: 0;">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.store') }}" method="POST" style="margin-bottom: 1.5rem;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <label style="font-weight: 600; color: #333; min-width: 80px;">Quantity:</label>
                        <div style="display: flex; align-items: center; border: 2px solid #e0e0e0; border-radius: 0.5rem; overflow: hidden;">
                            <button type="button" onclick="decreaseQty()" style="width: 40px; height: 40px; border: none; background-color: #f8f9fa; color: #666; font-size: 1.25rem; cursor: pointer; transition: all 0.2s;">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   style="width: 60px; height: 40px; border: none; text-align: center; font-weight: 600; font-size: 1rem;">
                            <button type="button" onclick="increaseQty()" style="width: 40px; height: 40px; border: none; background-color: #f8f9fa; color: #666; font-size: 1.25rem; cursor: pointer; transition: all 0.2s;">+</button>
                        </div>
                        <span style="color: #999; font-size: 0.875rem;">Max: {{ $product->stock }}</span>
                    </div>

                    <button type="submit" class="add-cart-btn" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.75rem; padding: 1rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; border: none; border-radius: 0.75rem; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4); transition: all 0.3s;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        Add to Cart
                    </button>
                </form>

                <!-- Share -->
                <div style="padding-top: 1.5rem; border-top: 2px solid #f0f0f0;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="font-weight: 600; color: #666;">Share:</span>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('detail', $product->id)) }}"
                               target="_blank" class="share-btn" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #3b5998; color: white; border-radius: 50%; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode(route('detail', $product->id)) }}"
                               target="_blank" class="share-btn" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #25d366; color: white; border-radius: 50%; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('detail', $product->id)) }}"
                               target="_blank" class="share-btn" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #1da1f2; color: white; border-radius: 50%; text-decoration: none; transition: all 0.2s;">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Tabs Section -->
        <div id="reviews-section" style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem;">
            
            <!-- Tab Navigation -->
            <div style="border-bottom: 2px solid #f0f0f0; margin-bottom: 2rem;">
                <div style="display: flex; gap: 2rem;">
                    <button onclick="showTab('description')" class="tab-btn active" data-tab="description"
                            style="padding: 1rem 0; border: none; background: none; font-weight: 600; font-size: 1rem; color: #666; border-bottom: 3px solid transparent; cursor: pointer; transition: all 0.2s;">
                        Description
                    </button>
                    <button onclick="showTab('reviews')" class="tab-btn" data-tab="reviews"
                            style="padding: 1rem 0; border: none; background: none; font-weight: 600; font-size: 1rem; color: #666; border-bottom: 3px solid transparent; cursor: pointer; transition: all 0.2s;">
                        Reviews ({{ $totalReviews }})
                    </button>
                </div>
            </div>

            <!-- Description Tab -->
            <div id="description-tab" class="tab-content">
                <div style="padding: 1rem 0;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Product Description</h3>
                    <p style="color: #666; line-height: 1.8; font-size: 1rem;">
                        {{ $product->description }}
                    </p>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews-tab" class="tab-content" style="display: none;">
                <div style="display: grid; grid-template-columns: 300px 1fr 350px; gap: 2rem;">
                    
                    <!-- Rating Summary -->
                    <div style="background-color: #fff9e6; border-radius: 1rem; padding: 2rem; text-align: center; border: 2px solid #ffe0b2;">
                        <div style="font-size: 3rem; font-weight: 700; color: #ff6b6b; margin-bottom: 0.5rem;">
                            {{ number_format($averageRating, 1) }}
                        </div>
                        <div style="display: flex; justify-content: center; gap: 0.25rem; margin-bottom: 0.5rem;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $fullStars)
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffc107" stroke="#ffc107" stroke-width="2">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                @elseif ($halfStar && $i == $fullStars + 1)
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="url(#half2)" stroke="#ffc107" stroke-width="2">
                                        <defs>
                                            <linearGradient id="half2">
                                                <stop offset="50%" stop-color="#ffc107"/>
                                                <stop offset="50%" stop-color="transparent"/>
                                            </linearGradient>
                                        </defs>
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                @else
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffc107" stroke-width="2">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p style="color: #666; font-size: 0.875rem; margin: 0;">Based on {{ $totalReviews }} reviews</p>
                        
                        <!-- Rating Breakdown -->
                        <div style="margin-top: 2rem; text-align: left;">
                            @foreach (range(5, 1) as $i)
                                @php
                                    $count = $reviews->where('rating', $i)->count();
                                    $percent = $reviews->count() ? ($count / $reviews->count()) * 100 : 0;
                                @endphp
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                                    <span style="font-size: 0.875rem; color: #666; min-width: 20px;">{{ $i }}</span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#ffc107" stroke="none">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                    <div style="flex: 1; height: 8px; background-color: #ffe0b2; border-radius: 4px; overflow: hidden;">
                                        <div style="width: {{ $percent }}%; height: 100%; background-color: #ffc107; transition: width 0.3s;"></div>
                                    </div>
                                    <span style="font-size: 0.875rem; color: #666; min-width: 30px; text-align: right;">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div style="max-height: 600px; overflow-y: auto; padding-right: 1rem;">
                        @forelse ($reviews as $review)
                            <div style="padding: 1.5rem; background-color: #f8f9fa; border-radius: 0.75rem; margin-bottom: 1rem; border: 1px solid #e0e0e0;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                    <div>
                                        <div style="font-weight: 700; color: #333; margin-bottom: 0.25rem;">{{ $review->name }}</div>
                                        <div style="font-size: 0.75rem; color: #999;">{{ $review->created_at->format('d M Y') }}</div>
                                    </div>
                                    <div style="display: flex; gap: 0.125rem;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? '#ffc107' : 'none' }}" stroke="#ffc107" stroke-width="2">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p style="color: #666; line-height: 1.6; margin: 0;">{{ $review->review }}</p>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 3rem; color: #999;">
                                <svg style="margin: 0 auto 1rem; color: #ddd;" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <p>No reviews yet. Be the first to review!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Submit Review Form -->
                    {{-- <div style="background-color: #f8f9fa; border-radius: 1rem; padding: 1.5rem; border: 2px solid #e0e0e0;">
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: #333; margin-bottom: 1.5rem;">Write a Review</h3>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-weight: 600; color: #666; margin-bottom: 0.5rem; font-size: 0.875rem;">Your Name</label>
                                <input type="text" name="name" placeholder="Enter your name" required
                                       value="{{ Auth::check() ? Auth::user()->name : '' }}"
                                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.875rem;">
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-weight: 600; color: #666; margin-bottom: 0.5rem; font-size: 0.875rem;">Your Email</label>
                                <input type="email" name="email" placeholder="Enter your email" required
                                       value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.875rem;">
                            </div>

                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-weight: 600; color: #666; margin-bottom: 0.5rem; font-size: 0.875rem;">Your Rating</label>
                                <select name="rating" required
                                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.875rem;">
                                    <option value="" disabled selected>Select rating</option>
                                    <option value="5">★★★★★ - Excellent</option>
                                    <option value="4">★★★★ - Good</option>
                                    <option value="3">★★★ - Average</option>
                                    <option value="2">★★ - Poor</option>
                                    <option value="1">★ - Terrible</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label style="display: block; font-weight: 600; color: #666; margin-bottom: 0.5rem; font-size: 0.875rem;">Your Review</label>
                                <textarea name="review" placeholder="Share your experience..." required rows="4"
                                          style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; font-size: 0.875rem; resize: vertical;"></textarea>
                            </div>

                            <button type="submit" class="submit-review-btn"
                                    style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3); transition: all 0.2s;">
                                Submit Review
                            </button>
                        </form>
                    </div> --}}

                </div>
            </div>

        </div>

    </div>
</div>

<style>
/* Button Hover Effects */
.add-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.5) !important;
}

.add-cart-btn:active {
    transform: translateY(0);
}

.share-btn:hover {
    transform: translateY(-2px) scale(1.1);
}

.submit-review-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4) !important;
}

/* Tab Styles */
.tab-btn.active {
    color: #ff6b6b !important;
    border-bottom-color: #ff6b6b !important;
}

.tab-btn:hover {
    color: #ff6b6b !important;
}

/* Quantity Button Hover */
button[onclick*="Qty"]:hover {
    background-color: #ff6b6b !important;
    color: white !important;
}

/* Scrollbar */
div[style*="overflow-y: auto"]::-webkit-scrollbar {
    width: 6px;
}

div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
    background: #ff6b6b;
    border-radius: 10px;
}

/* Responsive */
@media (max-width: 1024px) {
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    div[style*="grid-template-columns: 300px 1fr 350px"] {
        grid-template-columns: 1fr !important;
    }
}

@media (max-width: 768px) {
    div[style*="font-size: 2rem"] {
        font-size: 1.5rem !important;
    }
}

/* Smooth transitions */
* {
    transition: background-color 0.2s, color 0.2s, transform 0.2s;
}
</style>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.style.display = 'none';
    });
    
    // Remove active class from all buttons
    const tabBtns = document.querySelectorAll('.tab-btn');
    tabBtns.forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').style.display = 'block';
    
    // Add active class to clicked button
    document.querySelector(`.tab-btn[data-tab="${tabName}"]`).classList.add('active');
}

function increaseQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value);
    
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQty() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.getAttribute('min'));
    const current = parseInt(input.value);
    
    if (current > min) {
        input.value = current - 1;
    }
}


// Validate quantity input to prevent manual entry beyond stock
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    
    quantityInput.addEventListener('input', function() {
        const max = parseInt(this.getAttribute('max'));
        const min = parseInt(this.getAttribute('min'));
        let value = parseInt(this.value);
        
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        value = parseInt(this.value);
        
        // Check if value exceeds max
        if (value > max) {
            this.value = max;
            alert('Maximum quantity available is ' + max);
        }
        
        // Check if value is below min
        if (value < min || isNaN(value)) {
            this.value = min;
        }
    });
    
    // Prevent form submission if quantity exceeds stock
    const form = quantityInput.closest('form');
    form.addEventListener('submit', function(e) {
        const quantity = parseInt(quantityInput.value);
        const max = parseInt(quantityInput.getAttribute('max'));
        
        if (quantity > max) {
            e.preventDefault();
            alert('Quantity cannot exceed available stock (' + max + ')');
            quantityInput.value = max;
        }
        
        if (quantity < 1 || isNaN(quantity)) {
            e.preventDefault();
            alert('Please enter a valid quantity');
            quantityInput.value = 1;
        }
    });
});
</script>
@endsection