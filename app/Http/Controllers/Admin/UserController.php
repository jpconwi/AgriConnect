<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update(['status' => 'active']);
        return back()->with('status', "{$user->name} has been approved.");
    }

    public function suspend(User $user): RedirectResponse
    {
        $user->update(['status' => 'suspended']);
        return back()->with('status', "{$user->name} has been suspended.");
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update(['status' => 'active']);
        return back()->with('status', "{$user->name} has been reactivated.");
    }
}
