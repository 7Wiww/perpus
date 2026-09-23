@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-900 mb-5">Informasi Profil</h3>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h3 class="font-semibold text-gray-900 mb-5">Ubah Password</h3>
        @include('profile.partials.update-password-form')
    </div>

    <div class="bg-white rounded-2xl border border-red-100 p-6">
        <h3 class="font-semibold text-red-700 mb-5">Hapus Akun</h3>
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
