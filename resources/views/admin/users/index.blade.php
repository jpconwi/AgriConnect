@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
<h3 class="mb-3">Manage Users</h3>
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="role" class="form-select" onchange="this.form.submit()">
            <option value="">All roles</option>
            @foreach(['admin','farmer','supplier','buyer'] as $r)
                <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">All statuses</option>
            @foreach(['pending','active','suspended'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
</form>
<div class="table-responsive">
<table class="table bg-white shadow-sm align-middle">
    <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge bg-light text-dark border">{{ ucfirst($user->role) }}</span></td>
            <td>
                @php
                $badge = ['pending' => 'warning', 'active' => 'success', 'suspended' => 'danger'][$user->status];
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst($user->status) }}</span>
            </td>
            <td class="text-end">
                @if($user->status === 'pending')
                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-success">Approve</button>
                    </form>
                @endif
                @if($user->status !== 'suspended')
                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-danger">Suspend</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-outline-success">Reactivate</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted py-4">No users found.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $users->links() }}
@endsection
