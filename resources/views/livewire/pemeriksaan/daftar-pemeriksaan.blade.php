@section('title', 'Pemeriksaan Belanja')

<div class="main-content">
    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pemeriksaan Pengajuan Belanja</p>
        </div>

        {{-- Body --}}
        <div class="section-body">{{-- Notification --}}
            @include('components.notification.flash')

            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-header bg-light">
                            <span style="font-size: 1.25rem">Daftar Pengajuan Belanja</span>
                        </div>
                        {{-- Card Body --}}
                        <div class="card-body">
                            @if (auth()->user()->hasRole('ppk'))
                                @include('livewire.pemeriksaan.template.activity-by-role', [
                                    'data'     => $checkByCoordinator,
                                    'role'     => 'koordinator',
                                    'data_ppk' => $checkByCommitOfficer
                                ])
                            @elseif (auth()->user()->hasRole('koordinator'))
                                @include('livewire.pemeriksaan.template.activity-by-role', [
                                    'data'     => $checkByCoordinator,
                                    'role'     => 'koordinator',
                                    'data_ppk' => null
                                ])
                            @elseif (auth()->user()->hasRole('binagram'))
                                @include('livewire.pemeriksaan.template.activity-by-role', [
                                    'data'     => $checkByPlanner,
                                    'role'     => 'binagram',
                                    'data_ppk' => null
                                ])
                            @elseif (auth()->user()->hasRole('sekretaris'))
                                @include('livewire.pemeriksaan.template.activity-by-role', [
                                    'data'     => $checkBySecretary,
                                    'role'     => 'sekretaris',
                                    'data_ppk' => null
                                ])
                            @elseif (auth()->user()->hasRole('kpa'))
                                @include('livewire.pemeriksaan.template.activity-by-role', [
                                    'data'     => $checkByHeadOffice,
                                    'role'     => 'kpa',
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
