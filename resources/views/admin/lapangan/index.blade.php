@extends('layouts.admin')

@section('title', 'Kelola Lapangan')
@section('page_title', 'Kelola Lapangan')
@section('page_subtitle', 'Tambah, edit, dan hapus lapangan')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.lapangan.create') }}" class="btn-primary py-2.5 px-5 text-sm gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Lapangan
    </a>
</div>

<div class="card-admin rounded-2xl animate-fade-in-up">
    <div class="overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Harga/Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fields as $field)
                    <tr>
                        <td>
                            <div class="w-16 h-12 rounded-lg overflow-hidden bg-surface-100">
                                @if($field->photo)
                                    <img src="{{ asset('fields/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <i data-lucide="image" class="w-5 h-5 text-surface-300"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <p class="font-semibold text-surface-900">{{ $field->name }}</p>
                            <p class="text-xs text-surface-400 line-clamp-1">{{ $field->description ?? '-' }}</p>
                        </td>
                        <td>
                            @if($field->type)
                                <span class="text-sm font-medium text-primary-600 capitalize">{{ str_replace('_', ' ', $field->type) }}</span>
                            @else
                                <span class="text-sm text-surface-400">-</span>
                            @endif
                        </td>
                        <td class="font-semibold text-primary-600">{{ $field->formatted_price }}</td>
                        <td>
                            <span class="badge badge-{{ $field->status }}">{{ ucfirst($field->status) }}</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.lapangan.edit', $field->id) }}" class="p-2 rounded-lg text-surface-500 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.lapangan.destroy', $field->id) }}" onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-surface-500 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-surface-400">Belum ada lapangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fields->hasPages())
        <div class="px-6 py-4 border-t border-surface-100">
            {{ $fields->links() }}
        </div>
    @endif
</div>

@endsection
