@section('title', 'Dashboard')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Dashboard</p>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="font-weight-bold">
                        @include('components.notification.flash')
                    </div>

                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-cloud-sun"></i>
                            </div>
                            <p class="h5 ml-2 mt-2" style="letter-spacing: 1px;opacity:70%">
                                {{ \Carbon\Carbon::now()->locale('id')->dayName }}, {{ DateFormat::convertDateTime(\Carbon\Carbon::now()) }}
                            </p>
                            <p class="h4 ml-2 mt-3 font-weight-bold" style="letter-spacing: 1px">Selamat Datang, {{ auth()->user()->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dashboard Level Penanggung Jawab Anggaran --}}
            @hasanyrole('kpa|koordinator|ppk|binagram')
                @include('livewire.dashboard.pimpinan')
            @endhasanyrole

            @hasanyrole('subkoordinator|staf')
                @if (!auth()->user()->hasRole('binagram'))
                    @include('livewire.dashboard.pelaksana')
                @endif
            @endhasanyrole
        </div>
    </section>

      {{-- Modal --}}
    @if ($changePasswordModal)
        @livewire('auth.ganti-password')
    @endif
</div>
