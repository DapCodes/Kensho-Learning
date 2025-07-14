<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function impersonate($id)
    {
        $admin = Auth::user();
        $user = User::findOrFail($id);

        if ($admin->canImpersonate() && $user->canBeImpersonated()) {
            $admin->impersonate($user);

            return redirect('/dasbor'); // Ganti dengan route tujuan setelah impersonate
        }

        return redirect()->back()->with('error', 'Cannot impersonate this user.');
    }

    public function leave()
    {
        Auth::user()->leaveImpersonation();

        return redirect('/admin/users'); // Ganti dengan halaman admin
    }
}
