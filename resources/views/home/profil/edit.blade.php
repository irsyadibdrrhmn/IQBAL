@extends('layouts.app')

@section('content')
<div style="background-color: #f8f9fa; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 1rem;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="position: relative; display: inline-block;">
                <img src="{{ $user->image ? asset($user->image) : 'https://i.pravatar.cc/120?u=' . $user->email }}" 
                     alt="Avatar"
                     style="width: 120px; height: 120px; border-radius: 50%; border: 5px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1); object-fit: cover;">
                <div style="position: absolute; bottom: 5px; right: 5px; background-color: #ff6b6b; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                    <i class="fas fa-user-edit"></i>
                </div>
            </div>
            <h2 style="margin-top: 1rem; font-weight: 700; color: #333;">Edit Profil</h2>
            <p style="color: #777;">Perbarui informasi akun Anda ✨</p>
        </div>

        <!-- Edit Form -->
        <div style="background-color: white; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 2rem;">
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="name" style="font-weight: 600; color: #555;">Nama Lengkap</label>
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-top: 0.4rem;">
                        <i class="fas fa-user" style="color: #ff6b6b;"></i>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" 
                               style="flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 0.6rem 1rem;">
                    </div>
                </div>

                <!-- Email -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="font-weight: 600; color: #555;">Email</label>
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-top: 0.4rem;">
                        <i class="fas fa-envelope" style="color: #ff6b6b;"></i>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" 
                               style="flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 0.6rem 1rem;">
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="nomor_telpon" style="font-weight: 600; color: #555;">Nomor Telepon</label>
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-top: 0.4rem;">
                        <i class="fas fa-phone-alt" style="color: #ff6b6b;"></i>
                        <input type="text" id="nomor_telpon" name="nomor_telpon" value="{{ $user->nomor_telpon }}" 
                               style="flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 0.6rem 1rem;">
                    </div>
                </div>

                <!-- Alamat -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="alamat" style="font-weight: 600; color: #555;">Alamat</label>
                    <div style="display: flex; align-items: flex-start; gap: 0.6rem; margin-top: 0.4rem;">
                        <i class="fas fa-map-marker-alt" style="color: #ff6b6b; margin-top: 0.5rem;"></i>
                        <textarea id="alamat" name="alamat" rows="2" 
                                  style="flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 0.6rem 1rem;">{{ $user->alamat }}</textarea>
                    </div>
                </div>

                <!-- Foto Profil -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="image" style="font-weight: 600; color: #555;">Foto Profil</label>
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-top: 0.4rem;">
                        <i class="fas fa-image" style="color: #ff6b6b;"></i>
                        <input type="file" id="image" name="image" 
                               style="flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 0.6rem 1rem;">
                    </div>
                    @if($user->image)
                        <div style="text-align: center; margin-top: 1rem;">
                            <img src="{{ asset($user->image) }}" alt="Foto Saat Ini" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        </div>
                    @endif
                </div>

                <!-- Buttons -->
                <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                    <a href="{{ route('profil') }}" 
                       style="border: 2px solid #ff6b6b; color: #ff6b6b; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; text-decoration: none; transition: 0.3s;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>

                    <button type="submit" 
                            style="background-color: #ff6b6b; color: white; border: none; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; box-shadow: 0 3px 8px rgba(255, 107, 107, 0.3); transition: all 0.3s;">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
