<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('sso', 'Auth\LoginController@sso')->name('sso');
Route::get('pdf/{id}', 'PdfController@generate')->name('pdf.generate');
Route::post('pok/allocation', 'PokController@store')->name('pok.allocation.save');

Route::layout('layouts.auth')->middleware('guest')->group(function() {
    Route::livewire('login', 'auth.login')->name('auth.login');
});

Route::layout('layouts.app')->middleware('auth')->group(function() {
    Route::livewire('dashboard', 'dashboard.index');

    Route::prefix('kertas-kerja')->group(function() {
        // Pok
        Route::livewire('daftar-pok', 'kertas-kerja.pok.daftar-pok');
        Route::livewire('unggah-pok', 'kertas-kerja.pok.unggah-pok');
        Route::livewire('lihat-pok/{tahun}/{versi}', 'kertas-kerja.pok.lihat-pok');

        // Alokasi Anggaran
        Route::livewire('alokasi-anggaran', 'kertas-kerja.manajemen-anggaran.lihat-alokasi-anggaran');
        Route::livewire('alokasi-anggaran/buat', 'kertas-kerja.manajemen-anggaran.buat-alokasi-anggaran');

        // MSM
        Route::livewire('msm/buat', 'kertas-kerja.perubahan-anggaran.buat-edit-msm');
        Route::livewire('msm/{reference}/edit', 'kertas-kerja.perubahan-anggaran.buat-edit-msm');

        // Pengajuan MSM
        Route::livewire('pengajuan-msm', 'kertas-kerja.perubahan-anggaran.proposal.daftar-msm-proposal');
        Route::livewire('pengajuan-msm/{reference}/detail', 'kertas-kerja.perubahan-anggaran.proposal.detail-msm-proposal');

        // Pemeriksaan MSM
        Route::livewire('pemeriksaan-msm', 'kertas-kerja.perubahan-anggaran.pemeriksaan.daftar-msm-pemeriksaan');
        Route::livewire('pemeriksaan-msm/{refid}/{role}/detail', 'kertas-kerja.perubahan-anggaran.pemeriksaan.detail-msm-pemeriksaan');
    });

    Route::prefix('tata-kelola')->group(function() {
        Route::livewire('alokasi-perjalanan-dinas', 'management.trip-allocation.lists');
        Route::livewire('alokasi-perjalanan-dinas/buat', 'management.trip-allocation.create-allocation');
    });

    Route::prefix('belanja')->group(function() {
        Route::livewire('daftar-pengajuan-kegiatan', 'kegiatan.daftar-kegiatan');

        // Paket Meeting
        Route::livewire('paket-meeting', 'belanja.paket-meeting.daftar-pengajuan');
        Route::livewire('paket-meeting/pengajuan', 'belanja.paket-meeting.buat-pengajuan');
        Route::livewire('paket-meeting/detail/{id}', 'belanja.paket-meeting.detail-pengajuan');
        // Route::livewire('paket-meeting/buat', 'kegiatan.paket-meeting.buat-edit-paket-meeting');
        // Route::livewire('paket-meeting/{fullboard}/edit', 'kegiatan.paket-meeting.buat-edit-paket-meeting');

        // Lembur
        Route::livewire('lembur', 'belanja.lembur.daftar-pengajuan');
        Route::livewire('lembur/pengajuan', 'belanja.lembur.buat-pengajuan');
        Route::livewire('lembur/detail/{id}', 'belanja.lembur.detail-pengajuan');
        // Route::livewire('lembur/buat', 'kegiatan.lembur.buat-edit-lembur');
        // Route::livewire('lembur/{overtime}/edit', 'kegiatan.lembur.buat-edit-lembur');

        // Perjalanan Dinas
        Route::livewire('perjalanan-dinas', 'belanja.perjalanan-dinas.daftar-pengajuan');
        Route::livewire('perjalanan-dinas/pengajuan', 'belanja.perjalanan-dinas.buat-pengajuan');
        Route::livewire('perjalanan-dinas/detail/{id}', 'belanja.perjalanan-dinas.detail-pengajuan');
        // Route::livewire('perjalanan-dinas/buat', 'kegiatan.perjalanan-dinas.buat-edit-perjalanan-dinas');
        // Route::livewire('perjalanan-dinas/{trip}/edit', 'kegiatan.perjalanan-dinas.buat-edit-perjalanan-dinas');
    });

    // Pemeriksaan Pengajuan Belanja
    Route::livewire('pemeriksaan', 'pemeriksaan.daftar-pemeriksaan');
    Route::livewire('pemeriksaan/{id}/{role}', 'pemeriksaan.detail-pemeriksaan');

    // Tindak Lanjut Hasil Pemeriksaan Pengajuan Belanja
    Route::livewire('tindak-lanjut/{unit}', 'tindak-lanjut.daftar-tindak-lanjut');
    Route::livewire('tindak-lanjut/{id}', 'tindak-lanjut.detail-tindak-lanjut');

    Route::prefix('berkas')->group(function() {
        Route::livewire('daftar-berkas', 'berkas.pengumpulan.daftar-berkas');
        Route::livewire('unggah-berkas/{berkas}', 'berkas.pengumpulan.upload');
        Route::livewire('daftar-verifikasi/{role}', 'berkas.verifikasi.daftar-berkas');
        Route::livewire('verifikasi-berkas/{id}', 'berkas.verifikasi.verifikasi-berkas');
        Route::livewire('realisasi-anggaran', 'berkas.realisasi.daftar-entri');
        Route::livewire('realisasi-anggaran/entri', 'berkas.realisasi.entri');
        Route::livewire('realisasi-anggaran/{realisasi}', 'berkas.realisasi.entri');
        Route::livewire('verifikasi-anggaran', 'berkas.realisasi.verifikasi.daftar-verifikasi');
        Route::livewire('verifikasi-anggaran/{realisasi}', 'berkas.realisasi.verifikasi.verifikasi');
    });

    Route::prefix('setting')->name('setting.')->group(function() {
        Route::livewire('user', 'setting.user.daftar-user');
        Route::livewire('role', 'setting.role.list-of-role')->name('role');
        Route::livewire('webhook', 'setting.webhook.list-of-webhook')->name('webhook');
        Route::livewire('log', 'setting.log.list-of-log')->name('log');
        Route::livewire('log/{log}/show', 'setting.log.show-log')->name('log.show');
    });
});
