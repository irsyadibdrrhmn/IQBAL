@php
    $isEdit = isset($voucher);
@endphp

<div class="space-y-5">

    {{-- Kode Voucher --}}
    <div>
        <label for="code" class="block text-sm font-medium mb-1" style="color: #616060;">Kode Voucher</label>
        <input type="text" name="code" id="code"
               value="{{ old('code', $isEdit ? $voucher->code : '') }}"
               class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060]"
               required>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="description" class="block text-sm font-medium mb-1" style="color: #616060;">Deskripsi</label>
        <textarea name="description" id="description" rows="3"
                  class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060]">{{ old('description', $isEdit ? $voucher->description : '') }}</textarea>
    </div>

    {{-- Tipe Diskon dan Nilai --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label for="discount_type" class="block text-sm font-medium mb-1" style="color: #616060;">Tipe Diskon</label>
            <select name="discount_type" id="discount_type"
                    class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060]"
                    required>
                <option value="percent" {{ old('discount_type', $isEdit ? $voucher->discount_type : '') == 'percent' ? 'selected' : '' }}>Persentase</option>
                <option value="fixed" {{ old('discount_type', $isEdit ? $voucher->discount_type : '') == 'fixed' ? 'selected' : '' }}>Potongan Tetap</option>
            </select>
        </div>

        <div>
            <label for="discount_value" class="block text-sm font-medium mb-1" style="color: #616060;">Nilai Diskon</label>
            <input type="number" step="0.01" name="discount_value" id="discount_value"
                   value="{{ old('discount_value', $isEdit ? $voucher->discount_value : '') }}"
                   class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060]"
                   required>
        </div>
    </div>

    {{-- Kadaluarsa --}}
    <div>
        <label for="expires_at" class="block text-sm font-medium mb-1" style="color: #616060;">Tanggal Kadaluarsa</label>
        <input type="datetime-local" name="expires_at" id="expires_at"
               value="{{ old('expires_at', $isEdit && $voucher->expires_at ? $voucher->expires_at->format('Y-m-d\TH:i') : '') }}"
               class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060]">
    </div>

    {{-- Batas Penggunaan --}}
    <div>
        <label for="max_usage_per_user" class="block text-sm font-medium mb-1" style="color: #616060;">Batas Penggunaan per User</label>
        <input type="number" name="max_usage_per_user" min="1"
               value="{{ old('max_usage_per_user', $isEdit ? $voucher->max_usage_per_user : 1) }}"
               class="w-full border border-[#a09e9c] rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#e99c2e] focus:outline-none text-[#616060]"
               required>
    </div>

    {{-- Status Aktif --}}
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="is_active" id="is_active" value="1"
               class="w-4 h-4 text-[#e99c2e] border-gray-300 rounded focus:ring-[#e99c2e]"
               {{ old('is_active', $isEdit ? $voucher->is_active : true) ? 'checked' : '' }}>
        <label for="is_active" class="text-sm" style="color: #616060;">Voucher Aktif</label>
    </div>

</div>
