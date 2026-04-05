@extends('layouts.admin.app')

@section('content')


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-4 border-0" style="background-color: #fff; padding: 30px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-white border-0" style="font-size: 24px; font-weight: bold; color: #2c3e50;">
                    Edit Profil
                </div>
                <div class="card-body">
                    <form action="{{ route('profil.update.admin') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Row for Nama and Username -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label" style="font-size: 16px; color: #7f8c8d;">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" style="border-radius: 10px; padding: 10px;">
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="username" class="form-label" style="font-size: 16px; color: #7f8c8d;">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" style="border-radius: 10px; padding: 10px;">
                            </div> --}}
                        </div>

                        <!-- Row for Email and Nomor Telepon -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label" style="font-size: 16px; color: #7f8c8d;">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" style="border-radius: 10px; padding: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label for="nomor_telpon" class="form-label" style="font-size: 16px; color: #7f8c8d;">Nomor Telepon</label>
                                <input type="text" class="form-control" id="nomor_telpon" name="nomor_telpon" value="{{ $user->nomor_telpon }}" style="border-radius: 10px; padding: 10px;">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label" style="font-size: 16px; color: #7f8c8d;">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" style="border-radius: 10px; padding: 10px;">{{ $user->alamat }}</textarea>
                        </div>

                        <!-- Foto Profil -->
                        <div class="mb-3">
                            <label for="image" class="form-label" style="font-size: 16px; color: #7f8c8d;">Foto Profil</label>
                            <input type="file" class="form-control" id="image" name="image" style="border-radius: 10px; padding: 10px;">
                            @if($user->image)
                                <img src="{{ asset($user->image) }}" alt="Foto Saat Ini" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between" style="margin-top: 30px;">
                            <a href="{{ route('profil') }}" class="btn btn-secondary" style="padding: 10px 20px; background-color: #7f8c8d; color: white; border-radius: 20px;">Kembali</a>
                            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; background-color: #3498db; border: none; color: white; border-radius: 20px;">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
