@extends('layouts.admin.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-6" style="color: #5f5b57;">Tambah Voucher</h2>

    <div class="bg-white shadow-md rounded-2xl p-6">
        <form action="{{ route('vouchers.store') }}" method="POST" class="space-y-5">
            @csrf

            @include('vouchers.form')

            <div class="flex gap-3 pt-4">
                <button type="submit" 
                    class="px-5 py-2 rounded-xl font-medium text-white shadow transition duration-200 hover:opacity-90"
                    style="background-color: #e99c2e;">
                    Simpan
                </button>

                <a href="{{ route('vouchers.index') }}" 
                    class="px-5 py-2 rounded-xl font-medium text-white shadow transition duration-200 hover:opacity-90"
                    style="background-color: #a09e9c;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
