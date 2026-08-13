@extends('layouts.admin')

@section('title', 'Tambah Lapangan')
@section('page_title', 'Tambah Lapangan')
@section('page_subtitle', 'Tambah lapangan baru')

@section('content')

<div class="max-w-2xl">
    <div class="card-admin rounded-2xl p-6 sm:p-8 animate-fade-in-up">
        <form method="POST" action="{{ route('admin.lapangan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-5">
                <div>
                    <label for="name" class="form-label">Nama Lapangan</label>
                    <input type="text" name="name" id="name" class="form-input" placeholder="Contoh: Lapangan Futsal A" value="{{ old('name') }}" required>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="type" class="form-label">Tipe Lapangan</label>
                    <select name="type" id="type" class="form-input">
                        <option value="">Pilih Tipe</option>
                        @foreach(['futsal', 'badminton', 'basket', 'tenis', 'voli', 'mini_soccer'] as $type)
                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                    @error('type') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price_per_hour" class="form-label">Harga per Jam (Rp)</label>
                    <input type="number" name="price_per_hour" id="price_per_hour" class="form-input" placeholder="150000" value="{{ old('price_per_hour') }}" min="0" required>
                    @error('price_per_hour') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" class="form-input" placeholder="Deskripsi fasilitas lapangan...">{{ old('description') }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="photo" class="form-label">Foto Lapangan</label>
                    <input type="file" name="photo" id="photo" class="form-input" accept="image/jpeg,image/jpg,image/png,image/webp">
                    <p class="text-xs text-surface-400 mt-1">Format: JPEG, PNG, WebP. Maks: 2MB</p>
                    @error('photo') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-input" required>
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8">
                <button type="submit" class="btn-primary py-2.5 px-6 text-sm gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan
                </button>
                <a href="{{ route('admin.lapangan') }}" class="px-6 py-2.5 rounded-xl text-sm font-medium text-surface-600 hover:bg-surface-100 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
