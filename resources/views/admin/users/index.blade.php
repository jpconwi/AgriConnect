@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
<h3 class="ac-section-title mb-3"><i class="bi bi-people me-2 text-success"></i>Manage Users</h3>
<form method="GET" class="ac-filter-bar">
    <div class="row g-2">
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
    </div>
</form>
<div class="table-responsive">
<table class="table align-middle">
    <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ $user->avatar_url }}" style="width:32px;height:32px;border-radius:50%;" alt="">
                    <span class="fw-semibold">{{ $user->name }}</span>
                </div>
            </td>
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
        <tr><td colspan="5"><div class="ac-empty"><i class="bi bi-people ac-empty-icon"></i><p class="mb-0">No users found.</p></div></td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
