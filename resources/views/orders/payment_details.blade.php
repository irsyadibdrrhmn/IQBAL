@extends('layouts.app')

@section('content')
<div style="background-color: #f8f9fa; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 1000px; margin: 0 auto; padding: 0 1rem;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <h2 style="margin: 0 0 0.5rem 0; font-size: 1.75rem; font-weight: 700; color: #333;">Payment Details</h2>
            <p style="color: #666; font-size: 0.95rem; margin: 0;">Order ID: #{{ $order->id }}</p>
        </div>

        <!-- Main Card -->
        <div style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem; margin-bottom: 1.5rem;">
            
            <!-- Order Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; margin-bottom: 1.5rem; border-bottom: 2px solid #f0f0f0; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h4 style="margin: 0 0 0.25rem 0; font-size: 1.125rem; font-weight: 700; color: #333;">Order #{{ $order->id }}</h4>
                    <p style="margin: 0; font-size: 0.875rem; color: #999;">
                        <svg style="display: inline-block; vertical-align: middle; margin-right: 0.25rem;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        {{ $order->updated_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Total Amount</div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: #ff6b6b;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Payment Status -->
            <div style="margin-bottom: 1.5rem;">
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; font-weight: 600;">Payment Status</div>
                <span style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.625rem 1.25rem; border-radius: 2rem; font-weight: 600; font-size: 0.875rem; 
                    {{ $order->payment_status == 'paid' ? 'background-color: #d4edda; color: #155724;' : 
                       ($order->payment_status == 'failed' ? 'background-color: #f8d7da; color: #721c24;' : 'background-color: #fff3cd; color: #856404;') }}">
                    @if($order->payment_status == 'paid')
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    @endif
                    {{ strtoupper($order->payment_status) }}
                </span>
            </div>

            <!-- Info Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                
                <!-- Customer Info -->
                <div>
                    <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem; font-weight: 600;">Customer Information</div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span style="color: #333; font-weight: 600;">{{ $order->user->username }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span style="color: #666; font-size: 0.875rem;">{{ $order->user->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div>
                    <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem; font-weight: 600;">Delivery Address</div>
                    <div style="display: flex; align-items: start; gap: 0.5rem;">
                        <svg style="flex-shrink: 0; margin-top: 2px;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span style="color: #666; line-height: 1.5; font-size: 0.875rem;">{{ $order->address }}</span>
                    </div>
                </div>

                <!-- Payment History -->
                <div>
                    <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem; font-weight: 600;">Payment History</div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span style="color: #666; font-size: 0.875rem;">{{ $order->updated_at->format('d-m-Y H:i') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            <span style="color: #666; font-size: 0.875rem;">{{ $order->payment_method ?? 'Not specified' }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; 
                                {{ $order->payment_status == 'paid' ? 'background-color: #28a745;' : 
                                   ($order->payment_status == 'failed' ? 'background-color: #dc3545;' : 'background-color: #ffc107;') }}">
                            </div>
                            <span style="color: #666; font-size: 0.875rem;">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products List -->
            <div style="background-color: #f8f9fa; border-radius: 0.75rem; padding: 1.25rem; margin-bottom: 1.5rem;">
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1rem; font-weight: 600;">Order Items</div>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach ($order->orderItems as $item)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem; background-color: white; border-radius: 0.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                                <div style="width: 8px; height: 8px; background-color: #ff6b6b; border-radius: 50%;"></div>
                                @if ($item->product)
                                    <span style="color: #333; font-weight: 600;">{{ $item->product->name }}</span>
                                    <span style="color: #999; font-size: 0.875rem;">× {{ $item->quantity }}</span>
                                    @if($item->product->is_premium)
                                        <span style="padding: 0.25rem 0.5rem; background-color: #ffd93d; color: #333; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600;">PREMIUM</span>
                                    @endif
                                @elseif ($item->bundle)
                                    <span style="color: #333; font-weight: 600;">Bundle: {{ $item->bundle->name }}</span>
                                    <span style="color: #999; font-size: 0.875rem;">× {{ $item->quantity }}</span>
                                @else
                                    <span style="color: #999; font-style: italic;">Unknown item</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Button -->
            <div style="text-align: center; padding-top: 1rem; border-top: 2px solid #f0f0f0;">
                <a href="{{ route('home.index') }}" class="back-btn" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3); transition: all 0.2s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Back to Home
                </a>
            </div>

        </div>

    </div>
</div>

<style>
/* Button Hover Effects */
.back-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4) !important;
}

.back-btn:active {
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
    
    div[style*="display: flex"] {
        flex-wrap: wrap;
    }
}

/* Smooth transitions */
* {
    transition: background-color 0.2s, color 0.2s, transform 0.2s;
}
</style>
@endsection