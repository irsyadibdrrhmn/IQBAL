@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">🧍 Customer Dashboard</h2>
    <div class="alert alert-info">
        Hai, {{ Auth::user()->name }}! Anda login sebagai <strong>Customer</strong>.
    </div>
</div>
@endsection
