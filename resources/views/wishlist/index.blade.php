@extends('layouts.app')

@section('content')
<div style="background-color: #f8f9fa; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <h2 style="margin: 0 0 0.5rem 0; font-size: 1.75rem; font-weight: 700; color: #333;">My Wishlist</h2>
            <p style="color: #666; font-size: 0.95rem; margin: 0;">Save your favorite products for later</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($wishlists->isEmpty())
            <!-- Empty State -->
            <div style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 4rem 2rem; text-align: center;">
                <svg style="margin: 0 auto 1.5rem; color: #ddd;" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <h4 style="margin: 0 0 0.5rem 0; font-size: 1.25rem; font-weight: 600; color: #666;">Your Wishlist is Empty</h4>
                <p style="color: #999; margin: 0 0 1.5rem 0;">Start adding products you love!</p>
                <a href="{{ route('home.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; text-decoration: none; border-radius: 2rem; font-weight: 600; box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3); transition: all 0.3s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Browse Products
                </a>
            </div>
        @else
            <!-- Wishlist Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                @foreach($wishlists as $wishlist)
                    <div class="wishlist-card" style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden; transition: all 0.3s;">
                        
                        <!-- Product Image -->
                        <div style="position: relative; width: 100%; padding-top: 100%; background-color: #f8f9fa; overflow: hidden;">
                            <img src="{{ asset('images/' . $wishlist->product->image) }}" 
                                 alt="{{ $wishlist->product->name }}"
                                 style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                            
                            <!-- Premium Badge -->
                            @if($wishlist->product->is_premium)
                                <div style="position: absolute; top: 0.75rem; right: 0.75rem; padding: 0.375rem 0.75rem; background-color: #ffd93d; color: #333; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    PREMIUM
                                </div>
                            @endif

                            <!-- Wishlist Heart Icon -->
                            <div style="position: absolute; top: 0.75rem; left: 0.75rem; width: 36px; height: 36px; background-color: rgba(255, 255, 255, 0.95); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="#ff6b6b" stroke="#ff6b6b" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div style="padding: 1.25rem;">
                            <h5 style="margin: 0 0 0.5rem 0; font-size: 1rem; font-weight: 600; color: #333; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $wishlist->product->name }}
                            </h5>
                            
                            <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                                <div style="font-size: 1.25rem; font-weight: 700; color: #ff6b6b;">
                                    Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Stock Info -->
                            @if($wishlist->product->stock > 0)
                                <div style="display: flex; align-items: center; gap: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem; color: #28a745;">
                                    <div style="width: 8px; height: 8px; background-color: #28a745; border-radius: 50%;"></div>
                                    <span>In Stock ({{ $wishlist->product->stock }})</span>
                                </div>
                            @else
                                <div style="display: flex; align-items: center; gap: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem; color: #dc3545;">
                                    <div style="width: 8px; height: 8px; background-color: #dc3545; border-radius: 50%;"></div>
                                    <span>Out of Stock</span>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 0.5rem;">
                                <form action="{{ route('wishlist.remove', $wishlist->product->id) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 1rem; background-color: white; color: #dc3545; border: 1px solid #dc3545; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Remove
                                    </button>
                                </form>

                                <a href="{{ route('home.index') }}" class="view-btn" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.625rem 1rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3); transition: all 0.2s;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                {{ $wishlists->links() }}
            </div>
        @endif

        <!-- Back to Home Link -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('home.index') }}" style="color: #666; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Back to Home
            </a>
        </div>

    </div>
</div>

<style>
/* Card Hover Effects */
.wishlist-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
}

.wishlist-card img {
    transition: transform 0.3s;
}

.wishlist-card:hover img {
    transform: scale(1.05);
}

/* Button Hover Effects */
.remove-btn:hover {
    background-color: #dc3545;
    color: white;
}

.view-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4) !important;
}

.view-btn:active,
.remove-btn:active {
    transform: translateY(0);
}

/* Link Hover */
a:hover {
    color: #ff6b6b !important;
}

/* Responsive */
@media (max-width: 768px) {
    div[style*="grid-template-columns"] {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
        gap: 1rem !important;
    }
}

/* Smooth transitions */
* {
    transition: background-color 0.2s, color 0.2s, transform 0.2s;
}
</style>
@endsection