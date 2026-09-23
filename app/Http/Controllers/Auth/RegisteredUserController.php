<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:50', 'unique:users'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
            'no_telepon'=> ['nullable', 'string', 'max:20'],
            'alamat'    => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'anggota',
                'is_active'=> true,
            ]);

            Anggota::create([
                'user_id'          => $user->id,
                'no_anggota'       => Anggota::generateNoAnggota(),
                'no_telepon'       => $request->no_telepon,
                'alamat'           => $request->alamat,
                'jenis_anggota'    => 'mahasiswa',
                'status'           => 'aktif',
                'tanggal_bergabung'=> Carbon::today(),
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect(route('dashboard'));
    }
}
