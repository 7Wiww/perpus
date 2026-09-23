<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with('user');

        if ($request->search) {
            $q = $request->search;
            $query->where(function ($sq) use ($q) {
                $sq->where('no_anggota', 'like', "%$q%")
                   ->orWhere('nim_nip', 'like', "%$q%")
                   ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$q%")
                       ->orWhere('email', 'like', "%$q%"));
            });
        }
        if ($request->jenis_anggota) {
            $query->where('jenis_anggota', $request->jenis_anggota);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $anggotas = $query->latest()->paginate(10)->withQueryString();
        $stats = [
            'total'    => Anggota::count(),
            'aktif'    => Anggota::where('status', 'aktif')->count(),
            'nonaktif' => Anggota::where('status', 'nonaktif')->count(),
            'diblokir' => Anggota::where('status', 'diblokir')->count(),
        ];

        return view('admin.anggota.index', compact('anggotas', 'stats'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users',
            'username'         => 'required|string|max:50|unique:users',
            'nim_nip'          => 'nullable|string|max:20|unique:anggotas',
            'no_telepon'       => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'jenis_kelamin'    => 'nullable|in:laki-laki,perempuan',
            'jenis_anggota'    => 'required|in:mahasiswa,dosen,staff,umum',
            'program_studi'    => 'nullable|string|max:100',
            'fakultas_instansi'=> 'nullable|string|max:100',
            'tanggal_bergabung'=> 'nullable|date',
            'status'           => 'required|in:aktif,nonaktif,diblokir',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'catatan'          => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make('password'),
                'role'     => 'anggota',
                'is_active'=> true,
            ]);

            $foto = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto')->store('foto-anggota', 'public');
            }

            Anggota::create([
                'user_id'          => $user->id,
                'no_anggota'       => Anggota::generateNoAnggota(),
                'nim_nip'          => $request->nim_nip,
                'no_telepon'       => $request->no_telepon,
                'alamat'           => $request->alamat,
                'jenis_kelamin'    => $request->jenis_kelamin,
                'jenis_anggota'    => $request->jenis_anggota,
                'program_studi'    => $request->program_studi,
                'fakultas_instansi'=> $request->fakultas_instansi,
                'tanggal_bergabung'=> $request->tanggal_bergabung ?? Carbon::today(),
                'status'           => $request->status,
                'foto'             => $foto,
                'catatan'          => $request->catatan,
            ]);
        });

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan. Password default: password');
    }

    public function show(Anggota $anggota)
    {
        $anggota->load('user', 'peminjamans.bukus');
        return view('admin.anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        $anggota->load('user');
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $anggota->user_id,
            'nim_nip'          => 'nullable|string|max:20|unique:anggotas,nim_nip,' . $anggota->id,
            'no_telepon'       => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'jenis_kelamin'    => 'nullable|in:laki-laki,perempuan',
            'jenis_anggota'    => 'required|in:mahasiswa,dosen,staff,umum',
            'program_studi'    => 'nullable|string|max:100',
            'fakultas_instansi'=> 'nullable|string|max:100',
            'status'           => 'required|in:aktif,nonaktif,diblokir',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'catatan'          => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $anggota) {
            $anggota->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            $data = $request->only([
                'nim_nip', 'no_telepon', 'alamat', 'jenis_kelamin',
                'jenis_anggota', 'program_studi', 'fakultas_instansi',
                'status', 'catatan',
            ]);

            if ($request->hasFile('foto')) {
                if ($anggota->foto) Storage::disk('public')->delete($anggota->foto);
                $data['foto'] = $request->file('foto')->store('foto-anggota', 'public');
            }

            $anggota->update($data);
        });

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->peminjamansAktif()->exists()) {
            return back()->with('error', 'Anggota masih memiliki peminjaman aktif.');
        }
        DB::transaction(function () use ($anggota) {
            if ($anggota->foto) Storage::disk('public')->delete($anggota->foto);
            $anggota->user->delete();
        });
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
