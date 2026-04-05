@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h2 class="mb-4">
    @if(isset($merk))
      Produk dengan Merk: <strong>{{ $merk }}</strong>
    @elseif(isset($type))
      Produk dengan Type: <strong>{{ $type }}</strong>
    @else
      Semua Produk
    @endif
  </h2>

  <div class="row">
    @forelse ($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>

            {{-- Harga --}}
            @if ($product->discount && $product->discount->status === 'active')
              <p class="card-text">
                <span class="text-muted text-decoration-line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</span><br>
                <span class="text-danger fw-bold">Rp{{ number_format($product->discount->final_price, 0, ',', '.') }}</span>
              </p>
            @else
              <p class="card-text fw-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            @endif

            {{-- Merk & Type --}}
            <p class="mb-1"><strong>Merk:</strong> {{ $product->merk }}</p>
            <p><strong>Type:</strong> {{ $product->type }}</p>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info">Produk tidak ditemukan.</div>
      </div>
    @endforelse
  </div>

  <div class="mt-4">
    {{ $products->links() }}
  </div>
</div>
@endsection
