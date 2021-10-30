@section('title', 'Pemeriksaan Usulan Anggaran')

<div class="main-content">
    {{-- Notification --}}
    @include('components.notification.toast')

    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pemeriksaan Usulan Perubahan Anggaran (Matriks Semula Menjadi)</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        {{-- Card Body --}}
                        <div class="card-body">
                            @if (auth()->user()->hasRole('ppk'))
                                @include('livewire.kertas-kerja.perubahan-anggaran.msm-by-role', [
                                    'data'     => $checkByCoordinator,
                                    'role'     => 'koordinator',
                                    'data_ppk' => $checkByCommitOfficer
                                    ])
                            @elseif (auth()->user()->hasRole('koordinator'))
                                @include('livewire.kertas-kerja.perubahan-anggaran.msm-by-role', [
                                    'data'     => $checkByCoordinator,
                                    'role'     => 'koordinator',
                                    'data_ppk' => null
                                    ])
                            @elseif (auth()->user()->hasRole('binagram'))
                                @include('livewire.kertas-kerja.perubahan-anggaran.msm-by-role', [
                                    'data'     => $checkByPlanner,
                                    'role'     => 'binagram',
                                    'data_ppk' => null
                                    ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
