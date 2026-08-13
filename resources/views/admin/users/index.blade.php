@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('page_title', 'Kelola Admin')
@section('page_subtitle', 'Tambah dan kelola akun admin')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary py-2.5 px-5 text-sm gap-2">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        Tambah Admin
    </a>
</div>

<div class="card-admin rounded-2xl animate-fade-in-up">
    <div class="overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 text-sm font-bold shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-surface-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-sm">{{ $user->email }}</td>
                        <td class="text-sm">{{ $user->phone ?? '-' }}</td>
                        <td><span class="badge badge-confirmed">{{ ucfirst($user->role) }}</span></td>
                        <td class="text-sm text-surface-400">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 rounded-lg text-surface-500 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-surface-500 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-surface-400">Belum ada admin.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-surface-100">
            {{ $users->links() }}
        </div>
    @endif
</div>

@endsection
