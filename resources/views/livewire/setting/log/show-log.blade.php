@section('title', 'Informasi Log')

<div class="main-content">
    <section class="section" style="z-index=0">
        <div class="section-header">
            <p class="h3">Informasi Log </p>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card border rounded">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        {{-- Columns --}}
                                        <tr>
                                            <th width="15%">Waktu Log</th>
                                            <th>Environment</th>
                                            <th>Tipe</th>
                                            <th>Pesan Log</th>
                                        </tr>

                                        {{-- Content --}}
                                        @foreach ($content as $item)
                                            <tr>
                                                <td class="py-3">
                                                    <label class="font-weight-bold text-primary">
                                                        {{ DateFormat::convertDateTime($item['timestamp']) }}
                                                    </label><br>
                                                    <span class="text-muted">
                                                        {{
                                                            \Carbon\Carbon::parse($item['timestamp'])->diffForHumans()
                                                        }}
                                                    </span>
                                                </td>
                                                <td>{{ $item['env'] }}</td>
                                                <td>
                                                    @include('components.state.log-state', ['state' => $item['type']])
                                                </td>
                                                <td>{{ $item['message'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
