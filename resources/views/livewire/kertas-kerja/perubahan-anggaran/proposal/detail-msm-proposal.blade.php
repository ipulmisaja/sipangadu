@section('title', 'MSM ' . $reference->reference_id)

<div class="main-content">
    {{-- Notification --}}
    @include('components.notification.flash')

    {{-- Section --}}
    <section class="section" style="z-index:0">
        {{-- Header --}}
        <div class="section-header">
            <p class="h3">Informasi Pengajuan Usulan Perubahan Anggaran</p>
        </div>

        {{-- Body --}}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-body">

                            @include('components.item.detail', [
                                'detail' => $reference,
                                'type'   => 'msm'
                            ])

                            {{-- Catatan Pemeriksaan --}}
                            <hr>
                            <div class="form-group">
                                <p class="h6 font-weight-bold">
                                    <i class="fas fa-comment"></i>
                                    <span class="ml-1">Catatan Pemeriksaan</span>
                                </p>
                                <div class="p-3">
                                    @if($comments->count() > 0)
                                        <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                            @foreach($comments as $comment)
                                                @if($comment->commentator_type == 6)
                                                    @continue
                                                @else
                                                    @if($loop->first)
                                                        <li class="media p-3 border-left border-right border-top rounded-top" style="margin-bottom:0!important">
                                                            <img
                                                                alt="image"
                                                                class="mr-3 rounded-circle"
                                                                src="{{
                                                                    is_null($comment->userRelationship->foto)
                                                                        ? asset('vendor/stisla/img/avatar/avatar-1.png')
                                                                        : $comment->userRelationship->foto
                                                                    }}"
                                                                width="50"
                                                                height="83%"
                                                            >
                                                            <div class="media-body">
                                                                <div class="media-right">
                                                                    @include('components.state.approval-on-comment', [
                                                                        'data' => $comment->status
                                                                    ])
                                                                </div>
                                                                <div class="media-title mb-1">
                                                                    {{ $comment->userRelationship->nama }}
                                                                </div>
                                                                <div class="text-time">
                                                                    <span>
                                                                        <i class="fas fa-user mr-1"></i>
                                                                        @foreach($comment->userRelationship->roles as $role)
                                                                            <span>{{ $role->name }},</span>
                                                                        @endforeach
                                                                        <span>{{ $comment->userRelationship->unitRelationship->nama }}</span>
                                                                    </span>
                                                                    <span class="mx-2"> - </span>
                                                                    <span>
                                                                        <i class="fas fa-calendar mr-1"></i>
                                                                        {{ DateFormat::convertDateTime($comment->comment_date) }}
                                                                    </span>
                                                                </div>
                                                                <div class="h6 media-description text-muted">
                                                                    {!! $comment->description !!}
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @elseif($loop->last)
                                                            <li class="media p-3 bg-white border rounded-bottom" style="margin-bottom:0!important">
                                                                <img
                                                                    alt="image"
                                                                    class="mr-3 rounded-circle"
                                                                    src="{{
                                                                        is_null($comment->userRelationship->foto)
                                                                            ? asset('vendor/stisla/img/avatar/avatar-1.png')
                                                                            : $comment->userRelationship->foto
                                                                        }}"
                                                                    width="50"
                                                                    height="83%"
                                                                >
                                                                <div class="media-body">
                                                                    <div class="media-right">
                                                                        @include('components.state.approval-on-comment', [
                                                                            'data' => $comment->status
                                                                        ])
                                                                    </div>
                                                                    <div class="media-title mb-1">
                                                                        {{ $comment->userRelationship->nama }}
                                                                    </div>
                                                                    <div class="text-time">
                                                                        <span>
                                                                            <i class="fas fa-user mr-1"></i>
                                                                            @foreach($comment->userRelationship->roles as $role)
                                                                                <span>{{ $role->name }},</span>
                                                                            @endforeach
                                                                            <span>{{ $comment->userRelationship->unitRelationship->nama }}</span>
                                                                        </span>
                                                                        <span class="mx-2"> - </span>
                                                                        <span>
                                                                            <i class="fas fa-calendar mr-1"></i>
                                                                            {{ DateFormat::convertDateTime($comment->comment_date) }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="h6 media-description text-muted">
                                                                        {!! $comment->description !!}
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @else
                                                            <li class="media p-3 bg-white border-left border-right border-top" style="margin-bottom:0!important">
                                                                <img
                                                                    alt="image"
                                                                    class="mr-3 rounded-circle"
                                                                    src="{{
                                                                        is_null($comment->userRelationship->foto)
                                                                            ? asset('vendor/stisla/img/avatar/avatar-1.png')
                                                                            : $comment->userRelationship->foto
                                                                        }}"
                                                                    width="50"
                                                                    height="83%"
                                                                >
                                                                <div class="media-body">
                                                                    <div class="media-right">
                                                                        @include('components.state.approval-on-comment', [
                                                                            'data' => $comment->status
                                                                        ])
                                                                    </div>
                                                                    <div class="media-title mb-1">
                                                                        {{ $comment->userRelationship->nama }}
                                                                    </div>
                                                                    <div class="text-time">
                                                                        <span>
                                                                            <i class="fas fa-user mr-1"></i>
                                                                            @foreach($comment->userRelationship->roles as $role)
                                                                                <span>{{ $role->name }},</span>
                                                                            @endforeach
                                                                            <span>{{ $comment->userRelationship->unitRelationship->nama }}</span>
                                                                        </span>
                                                                        <span class="mx-2"> - </span>
                                                                        <span>
                                                                            <i class="fas fa-calendar mr-1"></i>
                                                                            {{ DateFormat::convertDateTime($comment->comment_date) }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="h6 media-description text-muted">
                                                                        {!! $comment->description !!}
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="ml-2">Belum ada catatan pemeriksaan.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Catatan Rekomendasi --}}
                            @if ($comments->count() === 3)
                                <hr>
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
