@extends('layouts.app')

@section('content')
<div style="max-width: 1080px; margin: 40px auto; padding: 32px; background-color: #fff; border-radius: 24px; box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08); font-family: 'Poppins', sans-serif;">

    <h2 style="text-align: center; font-size: 28px; font-weight: 600; color: #1f2937; margin-bottom: 30px;">
        📋 Daftar Pemesanan Costume
    </h2>

    @if(session('success'))
        <div style="background-color: #e1f9e7; color: #207541; border-left: 5px solid #28a745; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fdecec; color: #a94442; border-left: 5px solid #dc3545; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; border-radius: 12px; overflow: hidden;">
        <thead>
            <tr style="background-color: #f9fafb; color: #374151; text-align: left;">
                <th style="padding: 14px; border-bottom: 2px solid #e5e7eb;">Nama</th>
                <th style="padding: 14px; border-bottom: 2px solid #e5e7eb;">Tanggal</th>
                <th style="padding: 14px; border-bottom: 2px solid #e5e7eb;">Total</th>
                <th style="padding: 14px; border-bottom: 2px solid #e5e7eb;">Status</th>
                <th style="padding: 14px; border-bottom: 2px solid #e5e7eb;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemesanans as $pemesanan)
            <tr style="background-color: #ffffff; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='#ffffff'">
                <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">{{ $pemesanan->nama_pemesan }}</td>
                <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">{{ date('d M Y', strtotime($pemesanan->tanggal_pesan)) }}</td>
                <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">
                    <span style="padding: 6px 14px; font-size: 13px; border-radius: 50px; font-weight: 500;
                        background-color:
                            {{ $pemesanan->status_pembayaran === 'lunas' ? '#d4edda' :
                               ($pemesanan->status_pembayaran === 'pending' ? '#fff3cd' : '#f8d7da') }};
                        color:
                            {{ $pemesanan->status_pembayaran === 'lunas' ? '#155724' :
                               ($pemesanan->status_pembayaran === 'pending' ? '#856404' : '#721c24') }};
                        display: inline-block;">
                        {{ ucfirst($pemesanan->status_pembayaran) }}
                    </span>
                </td>
                <td style="padding: 12px; border-bottom: 1px solid #f3f4f6;">
                    @if($pemesanan->status_pembayaran === 'belum dibayar' || $pemesanan->status_pembayaran === 'pending')
                        <a href="{{ route('pemesanan.pay', $pemesanan->id) }}"
                           style="padding: 8px 16px; background-color: #3b82f6; color: #fff; text-decoration: none; border-radius: 8px; margin-right: 6px; font-size: 14px;">
                            💳 Bayar
                        </a>
                        <form action="{{ route('pemesanan.destroy', $pemesanan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Batalkan pemesanan ini?')"
                                    style="padding: 8px 16px; background-color: #ef4444; color: #fff; border: none; border-radius: 8px; font-size: 14px;">
                                ❌ Batal
                            </button>
                        </form>
                    @else
                        <span style="color: #22c55e; font-weight: 600; font-size: 14px;">✔ Sudah Dibayar</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 20px; text-align: center; color: #9ca3af;">Belum ada pemesanan costume.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
