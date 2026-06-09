@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna - Admin')
@section('header_title', 'Manajemen Pengguna')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-xl font-extrabold text-slate-800">Daftar Pengguna Terdaftar</h2>
                <p class="text-sm text-slate-500">Kelola akses dan pantau pengguna platform.</p>
            </div>
            <div class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-bold border border-blue-100">
                Total: {{ $users->total() }} Pengguna
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 rounded-l-xl">Info Pengguna</th>
                        <th class="px-6 py-4">Bergabung</th>
                        <th class="px-6 py-4 text-right">Saldo Wallet</th>
                        <th class="px-6 py-4 text-center">Role</th>
                        <th class="px-6 py-4 text-center rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-premium flex items-center justify-center text-white font-bold shadow-sm shrink-0">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $u->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                {{ $u->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-bold text-slate-800">Rp{{ number_format($u->balance, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($u->role == 'admin')
                                    <span class="px-3 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-lg text-xs font-bold uppercase tracking-wider">Admin</span>
                                @else
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 border border-slate-200 rounded-lg text-xs font-bold uppercase tracking-wider">User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if(auth()->id() !== $u->id)
                                    <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="role" value="{{ $u->role == 'admin' ? 'user' : 'admin' }}">
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ $u->role == 'admin' ? 'bg-orange-50 text-orange-600 hover:bg-orange-100' : 'bg-blue-50 text-blue-600 hover:bg-blue-100' }}">
                                            Jadikan {{ $u->role == 'admin' ? 'User' : 'Admin' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic">Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
