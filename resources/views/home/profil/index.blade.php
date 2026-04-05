@extends('layouts.app')

@section('content')
<div style="background-color: #f8f9fa; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 1rem;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="position: relative; display: inline-block;">
                <img src="https://i.pravatar.cc/120?u={{ Auth::user()->email }}" 
                     alt="Avatar"
                     style="width: 120px; height: 120px; border-radius: 50%; border: 5px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <div style="position: absolute; bottom: 5px; right: 5px; background-color: #ff6b6b; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <h2 style="margin-top: 1rem; font-weight: 700; color: #333;">{{ Auth::user()->name }}</h2>
            <p style="color: #777;">Profil Akun Anda</p>
        </div>

        <!-- Profile Card -->
        <div style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                
                <!-- Email -->
                <div>
                    <div style="font-size: 0.8rem; color: #999; text-transform: uppercase; font-weight: 600;">Email</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                        <i class="fas fa-envelope" style="color: #ff6b6b;"></i>
                        <span style="color: #333;">{{ Auth::user()->email }}</span>
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <div style="font-size: 0.8rem; color: #999; text-transform: uppercase; font-weight: 600;">Alamat</div>
                    <div style="display: flex; align-items: flex-start; gap: 0.5rem; margin-top: 0.5rem;">
                        <i class="fas fa-map-marker-alt" style="color: #ff6b6b; margin-top: 3px;"></i>
                        <span style="color: #333;">{{ Auth::user()->alamat ?? 'Belum diisi' }}</span>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <div style="font-size: 0.8rem; color: #999; text-transform: uppercase; font-weight: 600;">Nomor Telepon</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                        <i class="fas fa-phone-alt" style="color: #ff6b6b;"></i>
                        <span style="color: #333;">{{ Auth::user()->nomor_telpon ?? 'Belum diisi' }}</span>
                    </div>
                </div>

                <!-- Points -->
                {{-- <div>
                    <div style="font-size: 0.8rem; color: #999; text-transform: uppercase; font-weight: 600;">Points</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                        <i class="fas fa-star" style="color: #ffca28;"></i>
                        <span style="color: #333;">{{ Auth::user()->points ?? 0 }} Points</span>
                    </div>
                </div> --}}
            </div>

            <!-- Buttons -->
            <div style="display: flex; justify-content: space-between; margin-top: 2.5rem;">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        style="background-color: #ff6b6b; color: white; border: none; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; box-shadow: 0 3px 8px rgba(255, 107, 107, 0.3); transition: all 0.3s;">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>

                <a href="{{ route('profil.edit') }}" 
                   style="border: 2px solid #ff6b6b; color: #ff6b6b; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; text-decoration: none; transition: all 0.3s;">
                    <i class="fas fa-user-edit me-1"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
