@section('title', 'Pemeriksaan MSM ' . $pok->reference_id)

<div class="main-content">
    {{-- Notification --}}
    @include('components.notification.toast')

    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Pemeriksaan Pengajuan Usulan Perubahan Anggaran</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-body">
                            @include('components.item.detail', [
                                'detail' => $pok,
                                'type'   => 'msm'
                            ])

                            {{-- Catatan Rekomendasi --}}
                            <hr>
                            @if ($pok->approve_binagram <> 0)
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-comment-alt"></i>
                                        <span class="ml-1">Catatan Rekomendasi Dari Fungsi Perencanaan</span>
                                    </p>
                                    <div class="p-3">
                                        @foreach ($comments as $comment)
                                            @if($comment->commentator_type == 6)
                                                <div class="media border rounded p-3">
                                                    <div class="media-body">
                                                        <div class="media-right">
                                                            @if ($comment->status == 1)
                                                                <span class="badge badge-primary">
                                                                    <i class="fas fa-check-circle"></i>
                                                                    <span class="ml-1">Direkomendasikan</span>
                                                                </span>
                                                            @else
                                                                <span class="badge badge-warning">
                                                                    <i class="fas fa-times-circle"></i>
                                                                    <span class="ml-1">Tidak Direkomendasikan</span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="h6 media-description w-75">
                                                            {!! $comment->description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endif

                            {{-- Approval Section --}}
                            @if (auth()->user()->hasRole('binagram'))
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-edit"></i>
                                        <span class="ml-1">Pemberian Rekomendasi</span>
                                    </p>
                                    <p class="ml-4">
                                        Berikan rekomendasi terkait usulan perubahan anggaran ini dengan klik tombol
                                        <button wire:click="approval" class="ml-1 btn btn-primary">rekomendasi</button>
                                    </p>
                                </div>
                            @else
                                <div class="form-group">
                                    <p class="h6 font-weight-bold">
                                        <i class="fas fa-edit"></i>
                                        <span class="ml-1">Pemeriksaan Usulan</span>
                                    </p>
                                    <p class="ml-4">
                                        Berikan komentar, persetujuan, atau penolakan pada usulan yang diajukan dengan klik tombol
                                        <button wire:click="approval" class="ml-1 btn btn-primary">approval</button>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal --}}
    @if($modal)
        <div class="fixed-top h-100 rounded pt-5" style="background-color:rgba(0,0,0,.5)">
            <form wire:submit.prevent="save" class="mt-5">
                {{-- modal title --}}
                <div class="w-50 bg-white border-bottom px-5 py-4 mx-auto my-auto rounded-top">
                    <span class="h3">
                        {{
                            auth()->user()->hasRole('binagram')
                                ? 'Berikan Rekomendasi'
                                : 'Berikan Penilaian'
                        }}
                    </span>
                </div>
                {{-- modal content --}}
                <div class="w-50 bg-white px-5 py-5 mx-auto my-auto">
                    <div class="row">
                        <div class="col-3">
                            {{
                                auth()->user()->hasRole('binagram')
                                    ? 'Rekomendasi'
                                    : 'Status Approval'
                            }}
                        </div>
                        <div class="col-9">
                            <select wire:model="approval_state" class="form-control">
                                <option value="null">
                                    {{
                                        auth()->user()->hasRole('binagram')
                                            ? '- Status Rekomendasi -'
                                            : '- Status Approval -'
                                    }}
                                </option>
                                <option value="1">
                                    {{
                                        auth()->user()->hasRole('binagram')
                                            ? 'Ya'
                                            : 'Diterima'
                                    }}
                                </option>
                                <option value="2">
                                    {{
                                        auth()->user()->hasRole('binagram')
                                            ? 'Tidak'
                                            : 'Ditolak'
                                    }}
                                </option>
                            </select>
                            @error('approval_state')
                                <div class="mt-3">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-3">
                            {{
                                auth()->user()->hasRole('binagram')
                                    ? 'Deskripsi Rekomendasi'
                                    : 'Catatan Pemeriksaan'
                            }}
                        </div>
                        <div class="col-9">
                            <div wire:ignore x-data @trix-blur="$dispatch('change', $event.target.value)">
                                <trix-editor wire:model.lazy="comment" class="form-textarea"></trix-editor>
                            </div>
                            @error('comment')
                                <div class="mt-3">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- modal footer --}}
                <div class="d-flex w-50 bg-secondary mx-auto my-auto px-5 py-3 rounded-bottom">
                    <div class="w-100"></div>
                    <button wire:click="$emit('close')" class="btn btn-icon icon-left btn-danger mr-3">
                        <i class="far fa-times-circle"></i>
                        BATAL
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary">
                        <i class="far fa-save"></i>
                        SIMPAN
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
