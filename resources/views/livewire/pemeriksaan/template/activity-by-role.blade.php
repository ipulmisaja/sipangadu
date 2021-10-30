@if (is_null($data_ppk))
    @include('livewire.pemeriksaan.template.table-template', [
        'model' => $data,
        'route' => '',
        'role'  => $role
    ])
@else
    {{-- Data Pemeriksaan Koordinator --}}
    <label class="font-weight-bold">Pemeriksa Sebagai Koordinator Fungsi / Kepala Bagian</label>
    @include('livewire.pemeriksaan.template.table-template', [
        'model' => $data,
        'route' => '',
        'role'  => $role
    ])
    <hr class="my-5" style="border-top:dotted">
    <label class="font-weight-bold">Pemeriksa Sebagai Pejabat Pembuat Komitmen (PPK)</label>
    {{-- Data Pemeriksaan PPK --}}
    @include('livewire.pemeriksaan.template.table-template', [
        'model' => $data_ppk,
        'route' => '',
        'role'  => 'ppk'
    ])
@endif
