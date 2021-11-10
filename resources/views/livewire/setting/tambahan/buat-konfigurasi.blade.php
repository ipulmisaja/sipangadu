@section('title', 'Buat Konfigurasi Baru')

<div class="main-content">
    <section class="section" style="z-index:0">
        <div class="section-header">
            <p class="h3">Buat Konfigurasi Baru</p>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form wire:submit.prevent="save">
                        <div class="bg-white border-left border-top border-right rounded-top">
                            <div class="p-5">
                                <div class="row">
                                    <div class="col-3">Nama Pengajuan</div>
                                    <div class="col-9"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
