@if (is_null($data_ppk))
    @include('livewire.kertas-kerja.perubahan-anggaran.table-template', [
        'data' => $data,
        'role' => $role
    ])
@else
    {{-- Data Pemeriksaan Koordinator --}}
    <label class="font-weight-bold">Pemeriksa Sebagai Koordinator Fungsi</label>
    @include('livewire.kertas-kerja.perubahan-anggaran.table-template', [
        'data' => $data,
        'role' => $role
    ])

    <hr class="my-5" style="border-top:dotted">

    {{-- Data Pemeriksaan PPK --}}
    <label class="font-weight-bold">Pemeriksa Sebagai Pejabat Pembuat Komitmen</label>
    @include('livewire.kertas-kerja.perubahan-anggaran.table-template', [
        'data' => $data_ppk,
        'role' => 'ppk'
    ])
@endif
