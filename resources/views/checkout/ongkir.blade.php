@extends('layouts.app')

@section('content')
<div style="background-color: #f8f9fa; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        
        <!-- Progress Stepper -->
        <div style="margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; position: relative; max-width: 800px; margin: 0 auto;">
                <!-- Line Background -->
                <div style="position: absolute; top: 20px; left: 0; right: 0; height: 3px; background-color: #e0e0e0; z-index: 0;"></div>
                <div style="position: absolute; top: 20px; left: 0; width: 50%; height: 3px; background-color: #ff6b6b; z-index: 0;"></div>
                
                <!-- Step 1 - Cart (Completed) -->
                <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #4caf50; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);">✓</div>
                    <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #4caf50;">CART</span>
                </div>
                
                <!-- Step 2 - Payment (Completed) -->
                <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #4caf50; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);">✓</div>
                    <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #4caf50;">PAYMENT</span>
                </div>
                
                <!-- Step 3 - Delivery (Active) -->
                <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #ff6b6b; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);">3</div>
                    <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #ff6b6b;">DELIVERY</span>
                </div>
                
                <!-- Step 4 - Done -->
                <div style="display: flex; flex-direction: column; align-items: center; z-index: 1;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">4</div>
                    <span style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: 500; color: #999;">DONE</span>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2.5rem;">
            
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="margin: 0 0 0.5rem 0; font-size: 1.75rem; font-weight: 700; color: #333;">Check Shipping Area</h2>
                <p style="color: #666; font-size: 0.95rem; margin: 0;">Find your delivery area and calculate shipping costs</p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('ongkir.index') }}" style="margin-bottom: 2.5rem;">
                <div style="max-width: 600px; margin: 0 auto;">
                    <div style="display: flex; gap: 0.75rem;">
                        <div style="flex: 1; position: relative;">
                            <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #999;" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                            <input type="text" name="input" placeholder="Enter city name or area..." value="{{ old('input', $input ?? '') }}" style="width: 100%; padding: 0.875rem 1rem 0.875rem 3rem; border: 1px solid #ddd; border-radius: 0.75rem; font-size: 0.95rem; transition: all 0.2s;" onfocus="this.style.borderColor='#ff6b6b'; this.style.boxShadow='0 0 0 3px rgba(255,107,107,0.1)'" onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none'">
                        </div>
                        <button type="submit" style="padding: 0.875rem 2rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); color: white; border: none; border-radius: 0.75rem; font-weight: 600; font-size: 0.95rem; cursor: pointer; box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3); transition: all 0.3s; white-space: nowrap;">
                            Search
                        </button>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            @if(!empty($areas))
                <!-- Results Header -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%); border-radius: 0.75rem 0.75rem 0 0; margin-bottom: 0;">
                    <h4 style="margin: 0; color: white; font-size: 1rem; font-weight: 600;">Search Results ({{ count($areas) }} areas found)</h4>
                </div>

                <!-- Results Table -->
                <div style="border: 1px solid #f0f0f0; border-top: none; border-radius: 0 0 0.75rem 0.75rem; overflow: hidden;">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; width: 60px;">#</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Area Name</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Province</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">City</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">District</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;">Postal Code</th>
                                    <th style="padding: 1rem; text-align: center; font-weight: 600; color: #333; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($areas as $index => $area)
                                    <tr style="border-bottom: 1px solid #f0f0f0; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                                        <td style="padding: 1.25rem 1rem; text-align: center; color: #666; font-weight: 600;">{{ $index + 1 }}</td>
                                        <td style="padding: 1.25rem 1rem; color: #333; font-weight: 600;">{{ $area['name'] ?? '-' }}</td>
                                        <td style="padding: 1.25rem 1rem; color: #666;">{{ $area['administrative_division_level_1_name'] ?? '-' }}</td>
                                        <td style="padding: 1.25rem 1rem; color: #666;">{{ $area['administrative_division_level_2_name'] ?? '-' }}</td>
                                        <td style="padding: 1.25rem 1rem; color: #666;">{{ $area['administrative_division_level_3_name'] ?? '-' }}</td>
                                        <td style="padding: 1.25rem 1rem; text-align: center;">
                                            <span style="display: inline-block; padding: 0.375rem 0.75rem; background-color: #e3f2fd; color: #1976d2; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem;">
                                                {{ $area['postal_code'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td style="padding: 1.25rem 1rem; text-align: center;">
                                            <form action="{{ route('ongkir.setSession') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="area_id" value="{{ $area['id'] }}">
                                                <input type="hidden" name="area_name" value="{{ $area['name'] }}">
                                                <input type="hidden" name="postal_code" value="{{ $area['postal_code'] ?? '-' }}">
                                                <button type="submit" class="select-btn" style="padding: 0.5rem 1.25rem; background-color: #4caf50; color: white; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem;">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                    Select Area
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @elseif(!empty($input))
                <!-- No Results Message -->
                <div style="text-align: center; padding: 3rem 2rem;">
                    <svg style="margin: 0 auto 1rem; color: #ffd93d;" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <h4 style="margin: 0 0 0.5rem 0; font-size: 1.25rem; font-weight: 600; color: #333;">No Areas Found</h4>
                    <p style="color: #666; margin: 0;">We couldn't find any areas matching "<strong>{{ $input }}</strong>"</p>
                    <p style="color: #999; font-size: 0.875rem; margin-top: 0.5rem;">Try searching with different keywords or check your spelling</p>
                </div>
            @else
                <!-- Initial State -->
                <div style="text-align: center; padding: 3rem 2rem;">
                    <svg style="margin: 0 auto 1rem; color: #ddd;" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <h4 style="margin: 0 0 0.5rem 0; font-size: 1.25rem; font-weight: 600; color: #666;">Search for Your Area</h4>
                    <p style="color: #999; margin: 0;">Enter your city or area name to find shipping options</p>
                </div>
            @endif

        </div>

        <!-- Back Link -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('checkout.index') }}" style="color: #666; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to Checkout
            </a>
        </div>

    </div>
</div>

<style>
/* Button Hover Effects */
button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 107, 107, 0.4) !important;
}

button[type="submit"]:active {
    transform: translateY(0);
}

.select-btn:hover {
    background-color: #45a049 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
}

.select-btn:active {
    transform: translateY(0);
}

/* Link Hover */
a:hover {
    color: #ff6b6b !important;
}

/* Responsive */
@media (max-width: 768px) {
    table {
        font-size: 0.875rem;
    }
    
    th, td {
        padding: 0.75rem 0.5rem !important;
    }
    
    .select-btn {
        padding: 0.375rem 0.75rem !important;
        font-size: 0.813rem !important;
    }
    
    .select-btn svg {
        display: none;
    }
}

/* Smooth transitions */
* {
    transition: background-color 0.2s, color 0.2s, transform 0.2s;
}
</style>
@endsection