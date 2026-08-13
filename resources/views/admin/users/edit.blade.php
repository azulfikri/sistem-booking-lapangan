@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page_title', 'Edit Admin')
@section('page_subtitle', $user->name)

@section('content')

<div class="max-w-2xl">
    <div class="card-admin rounded-2xl p-6 sm:p-8 animate-fade-in-up">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="tel" name="phone" id="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-input" required>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                    @error('role') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="form-label">Password Baru <span class="text-surface-400 font-normal">(kosongkan jika tidak ingin ganti)</span></label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Minimal 8 karakter">
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8">
                <button type="submit" class="btn-primary py-2.5 px-6 text-sm gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Update
                </button>
                <a href="{{ route('admin.users') }}" class="px-6 py-2.5 rounded-xl text-sm font-medium text-surface-600 hover:bg-surface-100 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
