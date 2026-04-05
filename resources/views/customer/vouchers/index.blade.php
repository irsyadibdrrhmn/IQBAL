@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Riwayat Voucher Saya</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Diskon</th>
                <th>Tipe</th>
                <th>Diberikan</th>
                <th>Digunakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vouchers as $voucher)
                <tr>
                    <td>{{ $voucher->code }}</td>
                    <td>
                        {{ $voucher->discount_type == 'percent' ? $voucher->discount_value . '%' : 'Rp' . number_format($voucher->discount_value) }}
                    </td>
                    <td>{{ ucfirst($voucher->discount_type) }}</td>
                    <td>{{ $voucher->pivot->assigned_at }}</td>
                    <td>{{ $voucher->pivot->used_at ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada voucher</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
