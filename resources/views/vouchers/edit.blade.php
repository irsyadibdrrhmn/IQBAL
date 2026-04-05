@extends('layouts.admin.admin')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-6">
    
    <h2 class="text-2xl font-semibold mb-6" style="color: #5f5b57;">Edit Voucher</h2>

    <div class="bg-white shadow-md rounded-2xl p-6">
        <form action="{{ route('vouchers.update', $voucher) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            @include('vouchers.form', ['voucher' => $voucher])

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" 
                        class="px-5 py-2 rounded-lg font-medium shadow-sm transition duration-200"
                        style="background-color: #e99c2e; color: #ffffff;">
                    Update
                </button>

                <a href="{{ route('vouchers.index') }}" 
                   class="px-5 py-2 rounded-lg font-medium border border-[#a09e9c] transition duration-200"
                   style="color: #616060; background-color: #f9f9f9;">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
