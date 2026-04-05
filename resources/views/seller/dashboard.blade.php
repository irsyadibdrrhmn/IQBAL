@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">🛒 Seller Dashboard</h2>
    <div class="alert alert-primary">
        Halo, {{ Auth::user()->name }}! Anda login sebagai <strong>Seller</strong>.
    </div>
</div>
@endsection
