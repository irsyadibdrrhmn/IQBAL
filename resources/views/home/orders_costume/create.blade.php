@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin-top: 30px;">
    <h2 class="mb-4" style="font-size: 1.8rem; color: #333;">Form Pemesanan</h2>

    @if(session('error'))
        <div class="alert alert-danger" style="font-size: 0.875rem; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('simpan.costume') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_pemesan" class="form-label" style="font-size: 1rem;">Nama Pemesan</label>
            <input type="text" name="nama_pemesan" class="form-control" value="{{ old('nama_pemesan') }}" required
                style="border-radius: 8px; padding: 10px;">
        </div>

        <div class="mb-3">
            <label for="tanggal_pesan" class="form-label" style="font-size: 1rem;">Tanggal Pemesanan</label>
            <input type="date" name="tanggal_pesan" class="form-control" value="{{ old('tanggal_pesan') }}" required
                style="border-radius: 8px; padding: 10px;">
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label" style="font-size: 1rem;">Keterangan (Opsional)</label>
            <textarea name="keterangan" class="form-control" rows="3" style="border-radius: 8px; padding: 10px;">{{ old('keterangan') }}</textarea>
        </div>

        <h5 class="mt-4" style="font-size: 1.2rem; color: #444;">Pilih Bahan</h5>

        <div class="table-responsive" style="max-height: 400px; overflow-y: auto; margin-top: 20px;">
            <table class="table table-bordered align-middle" style="font-size: 0.875rem; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center; padding: 10px;">Pilih</th>
                        <th style="text-align: left; padding: 10px;">Nama Bahan</th>
                        <th style="text-align: right; padding: 10px;">Harga</th>
                        <th style="text-align: center; padding: 10px;">Stok</th>
                        <th style="text-align: center; padding: 10px;">Jumlah Dipesan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bahan as $item)
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" name="bahan_dipesan[{{ $item->id }}]" value="1"
                                    onchange="toggleJumlahInput({{ $item->id }})">
                            </td>
                            <td>{{ $item->nama_bahan }}</td>
                            <td style="text-align: right;">Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td style="text-align: center;">{{ $item->stok }}</td>
                            <td style="text-align: center;">
                                <input type="number" name="bahan_dipesan[{{ $item->id }}]" 
                                    id="jumlah_{{ $item->id }}"
                                    class="form-control"
                                    min="1" max="{{ $item->stok }}"
                                    style="width: 80px; padding: 5px; border-radius: 6px;"
                                    disabled>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary mt-3" style="font-size: 1rem; padding: 10px 20px; border-radius: 8px;">Simpan Pemesanan</button>
    </form>
</div>

<script>
    function toggleJumlahInput(id) {
        const checkbox = event.target;
        const jumlahInput = document.getElementById('jumlah_' + id);
        if (checkbox.checked) {
            jumlahInput.disabled = false;
            jumlahInput.value = 1;
        } else {
            jumlahInput.disabled = true;
            jumlahInput.value = '';
        }
    }
</script>
@endsection
