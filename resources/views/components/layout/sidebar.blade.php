<div class="main-sidebar sidebar-style-2" tabindex="1" style="overflow: hidden; outline: none;">
    <aside id="sidebar-wrapper">
        {{-- Sidebar title --}}
        <div class="sidebar-brand">
            <a href="{{ url(env('APP_URL') . 'dashboard') }}">SIPANGADU</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url(env('APP_URL') . 'dashboard') }}">SG</a>
        </div>

        {{-- Menu --}}
        <ul class="sidebar-menu">
            <li>
                <a href="{{ url(env('APP_URL') . 'dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            {{-- POK --}}
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="far fa-file-alt"></i>
                    <span>POK</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="mt-2">
                        <a class="nav-link" href="{{ url(env('APP_URL') . 'kertas-kerja/daftar-pok') }}">
                            Daftar POK
                        </a>
                    </li>
                    @if (auth()->user()->hasRole('subkoordinator') && auth()->user()->hasUnit('binagram'))
                        <li class="mt-2">
                            <a class="nav-link" href="{{ url(env('APP_URL') . 'kertas-kerja/alokasi-anggaran') }}">
                                Alokasi Anggaran
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasRole('subkoordinator'))
                        <li class="mt-2">
                            <a class="nav-link" href="{{ url(env('APP_URL') . 'kertas-kerja/pengajuan-msm') }}">
                                Matrik Semula Menjadi
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->hasRole(['ppk', 'koordinator']) || (auth()->user()->hasRole('subkoordinator') && auth()->user()->hasUnit('binagram')))
                        <li class="mt-2">
                            <a class="nav-link" href="{{ url(env('APP_URL') . 'kertas-kerja/pemeriksaan-msm') }}">
                                Pemeriksaan MSM
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            {{-- Tata kelola --}}
            @role('ppk')
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-pencil-ruler"></i>
                        <span>Tata Kelola</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'tata-kelola/alokasi-perjalanan-dinas') }}" class="nav-link">Alokasi Perjadin</a>
                        </li>
                        <li class="mt-2">
                            <a href="" class="nav-link">Mailinglist Pencetakan</a>
                        </li>
                    </ul>
                </li>
            @endrole

            {{-- Pengajuan Belanja --}}
            @role('subkoordinator')
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-shopping-basket"></i>
                        <span>Pengajuan Belanja</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'belanja/paket-meeting') }}">- Paket Meeting</a>
                        </li>
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'belanja/perjalanan-dinas') }}">- Perjalanan Dinas</a>
                        </li>
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'belanja/lembur') }}">- Lembur</a>
                        </li>
                    </ul>
                </li>
            @endrole

            {{-- Pemeriksaan --}}
            @hasanyrole('kpa|ppk|binagram|koordinator|sekretaris')
                <li class="dropdown">
                    <a href="{{ url(env('APP_URL') . 'pemeriksaan') }}" class="nav-link">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Pemeriksaan</span>
                    </a>
                </li>
            @endhasanyrole

            {{-- Tindak Lanjut --}}
            @role('subkoordinator')
                @if (auth()->user()->hasUnit('kepeghum'))
                    <li class="dropdown">
                        <a href="{{ url(env('APP_URL')) . 'tindak-lanjut/kepeghum' }}" class="nav-link">
                            <i class="fas fa-file-import"></i>
                            <span>Tindak Lanjut</span>
                        </a>
                    </li>
                @elseif (auth()->user()->hasUnit('keuangan'))
                    <li class="dropdown">
                        <a href="{{ url(env('APP_URL')) . 'tindak-lanjut/keuangan' }}" class="nav-link">
                            <i class="fas fa-file-import"></i>
                            <span>Tindak Lanjut</span>
                        </a>
                    </li>
                @elseif (auth()->user()->hasUnit('umum'))
                    <li class="dropdown">
                        <a href="{{ url(env('APP_URL')) . 'tindak-lanjut/umum' }}" class="nav-link">
                            <i class="fas fa-file-import"></i>
                            <span>Tindak Lanjut</span>
                        </a>
                    </li>
                @elseif (auth()->user()->hasUnit('pengadaan-barjas'))
                    <li class="dropdown">
                        <a href="{{ url(env('APP_URL')) . 'tindak-lanjut/pengadaan-barjas' }}" class="nav-link">
                            <i class="fas fa-file-import"></i>
                            <span>Tindak Lanjut</span>
                        </a>
                    </li>
                @endif
            @endrole

            {{-- Pengumpulan Berkas --}}
            @hasanyrole('ppk')
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-file-upload"></i>
                        <span>Pengumpulan Berkas</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url(env('APP_URL') . 'berkas/daftar-berkas') }}" class="nav-link">- Unggah</a>
                        </li>
                        <li>
                            <a href="{{ url(env('APP_URL') . 'berkas/daftar-verifikasi/ppk') }}" class="nav-link">- Verifikasi</a>
                        </li>
                    </ul>
                </li>
            @else
                @if (auth()->user()->hasUnit('keuangan') && auth()->user()->hasRole('subkoordinator'))
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="fas fa-file-upload"></i>
                            <span>Pengumpulan Berkas</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url(env('APP_URL') . 'berkas/daftar-berkas') }}" class="nav-link">- Unggah</a>
                            </li>
                            <li>
                                <a href="{{ url(env('APP_URL') . 'berkas/daftar-verifikasi/subkoordinator-keuangan') }}" class="nav-link">- Verifikasi</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="{{ url(env('APP_URL') . 'berkas/daftar-berkas') }}" class="nav-link">
                            <i class="fas fa-file-upload"></i>
                            <span>Unggah Berkas</span>
                        </a>
                    </li>
                @endif
            @endhasanyrole

            {{-- Entri Realisasi --}}
            @if (auth()->user()->hasUnit('binagram'))
                <li class="dropdown">
                    <a href="{{ url(env('APP_URL') . 'berkas/realisasi-anggaran') }}" class="nav-link">
                        <i class="fas fa-coins"></i>
                        <span>Entri Realisasi</span>
                    </a>
                </li>
            @endif

            @role('ppk')
                <li class="dropdown">
                    <a href="{{ url(env('APP_URL') . 'berkas/verifikasi-anggaran') }}" class="nav-link">
                        <i class="fas fa-wallet"></i>
                        <span>Verifikasi Realisasi</span>
                    </a>
                </li>
            @endrole

            {{-- Pengaturan Aplikasi --}}
            @role('admin')
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-user-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'setting/user') }}" class="nav-link">- User</a>
                        </li>
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'setting/role') }}" class="nav-link">- Hak Akses</a>
                        </li>
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'setting/tambahan') }}" class="nav-link">- Tambahan</a>
                        </li>
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'setting/webhook') }}">- Webhook</a>
                        </li>
                        <li class="mt-2">
                            <a href="{{ url(env('APP_URL') . 'setting/log') }}" class="nav-link">- Log Aplikasi</a>
                        </li>
                    </ul>
                </li>
            @endrole
        </ul>
    </aside>
</div>
