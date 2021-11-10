<?php

namespace App\Http\Livewire\Setting\Tambahan;

use App\Models\KonfigurasiTambahan;
use Livewire\Component;

class DaftarTambahan extends Component
{
    // Pengaturan yang diakomodir pada submenu ini adalah
    // - Tampilkan isian tanggal pengajuan dan tanggal approval
    // - Tampilkan pilihan POK lama pada pemilihan pengajuan

    public $konfigurasiTambahan;

    public function mount()
    {
        $this->konfigurasiTambahan = KonfigurasiTambahan::get();
    }

    public function render()
    {
        return view('livewire.setting.tambahan.daftar-tambahan');
    }
}
