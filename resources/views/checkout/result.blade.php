@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
        <h3 class="d-flex align-items-center" style="font-size: 24px; font-weight: bold;">Ongkir</h3>
    </div>

    @if(isset($result['rajaongkir']['results']) && !empty($result['rajaongkir']['results']))
        <div class="row">
            @foreach($result['rajaongkir']['results'] as $courier)
                @foreach($courier['costs'] as $cost)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm rounded-2 h-100">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold" style="letter-spacing: 0.5px;">{{ $courier['name'] }}</h5>

                                <p class="card-text mb-1" style="font-size: 14px;">
                                    <strong>Layanan:</strong> {{ $cost['service'] }}
                                </p>
                                <p class="card-text mb-1" style="font-size: 14px;">
                                    <strong>Biaya:</strong> Rp {{ number_format($cost['cost'][0]['value'], 0, ',', '.') }}
                                </p>
                                <p class="card-text mb-3" style="font-size: 14px;">
                                    <strong>Estimasi:</strong> {{ $cost['cost'][0]['etd'] }} Hari
                                </p>
                                <form action="{{ route('save-ongkir') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="courier" value="{{ $courier['name'] }}">
                                    <input type="hidden" name="service" value="{{ $cost['service'] }}">
                                    <input type="hidden" name="cost" value="{{ $cost['cost'][0]['value'] }}">
                                    <input type="hidden" name="etd" value="{{ $cost['cost'][0]['etd'] }}">
                                    <button type="submit" class="btn btn-outline-gray hvr-sweep-to-right dark-sweep" style="font-size: 14px; padding: 12px;">Pilih Ongkir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @else
        <div class="alert alert-danger" role="alert" style="font-size: 14px;">
            Gagal mengambil data ongkir. Silakan coba lagi.
        </div>
    @endif
</div>
@endsection
