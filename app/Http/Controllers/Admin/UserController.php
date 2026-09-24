<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\Activity;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->get('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%"))
            ->when($request->get('role'), fn ($q, $role) => $q->where('role', $role))
            ->when($request->has('is_active'), fn ($q) => $q->where('is_active', $request->boolean('is_active')))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        $user = User::create($data);

        Activity::record('user.created', $user);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil dibuat.");
    }

    public function show(User $user)
    {
        $user->load(['createdOrders' => fn ($q) => $q->latest()->limit(10)]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $user->update($data);

        Activity::record('user.updated', $user);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        $name = $user->name;

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->withErrors(['error' => 'Anda tidak dapat menghapus akun sendiri.']);
        }

        // Prevent deleting last super_admin
        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->withErrors(['error' => 'Tidak dapat menghapus user Super Admin terakhir.']);
        }

        $user->delete();

        Activity::record('user.deleted', null, ['user_id' => $user->id, 'name' => $name]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$name} berhasil dihapus.");
    }

    public function toggleActive(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak dapat menonaktifkan akun sendiri.']);
        }

        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->where('is_active', true)->count() <= 1 && $user->is_active) {
            return back()->withErrors(['error' => 'Tidak dapat menonaktifkan Super Admin terakhir.']);
        }

        $user->update(['is_active' => ! $user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        Activity::record('user.toggled', $user, ['action' => $status]);

        return back()->with('success', "User {$user->name} berhasil {$status}.");
    }
}
