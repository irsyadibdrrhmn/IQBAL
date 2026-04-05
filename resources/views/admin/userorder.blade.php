@extends('layouts.admin.app')<!-- Ganti sesuai layout-mu -->

@section('content')
<div class="container mt-4">
    <h3>Daftar User & Jumlah Order</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Jumlah Order (Paid)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->orders_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
