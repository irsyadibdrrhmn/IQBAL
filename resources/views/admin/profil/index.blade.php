@extends('layouts.admin.app')

@section('content')

<!-- PROFILE SECTION -->
<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Profile Card -->
        <div class="col-md-12">
            <div class="card shadow-lg rounded-lg">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <!-- Profile Image -->
                        <div class="col-md-4 text-center mb-4">
                            <img src="{{ asset($user->image) }}" alt="User Image" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <!-- Profile Details -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <h5 class="font-weight-bold text-muted">Nama</h5>
                                <p class="text-dark">{{ $user->name }}</p>
                            </div>

                            <div class="mb-3">
                                <h5 class="font-weight-bold text-muted">Email</h5>
                                <p class="text-dark">{{ $user->email }}</p>
                            </div>

                            <div class="mb-3">
                                <h5 class="font-weight-bold text-muted">Telepon</h5>
                                <p class="text-dark">{{ $user->nomor_telpon ?? '-' }}</p>
                            </div>

                            <div class="mb-3">
                                <h5 class="font-weight-bold text-muted">Alamat</h5>
                                <p class="text-dark">{{ $user->alamat ?? '-' }}</p>
                            </div>

                            <!-- Button to Edit Profile -->
                            <div class="text-center">
                                <a href="{{ route('profil.edit.admin') }}" class="btn btn-secondary btn-lg" style="border-radius: 30px;">
                                    <i class="fa fa-pencil-alt"></i> Lengkapi Data
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /PROFILE SECTION -->

@endsection
