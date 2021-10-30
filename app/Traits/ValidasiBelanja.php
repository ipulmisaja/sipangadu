<?php

namespace App\Traits;

trait ValidasiBelanja
{
    public function paketMeetingValidasi($data)
    {
        $trim = trim($data->availableBudget, ",-");
        $dots = str_replace(".", "", $trim);

        $data->validate([
            'tanggal_pengajuan' => 'required',
            'nota_dinas'        => 'required',
            'nama_kegiatan'     => 'required|string|min:5',
            'output'            => 'required',
            'detail'            => 'required',
            'budget'            => 'required|numeric|max:' . intval($dots),
            'file'              => 'required',
            'catatan'           => 'nullable|string'
        ]);
    }

    public function lemburValidasi($data)
    {
        $data->validate([
            'tanggal_pengajuan' => 'required',
            'nota_dinas'        => 'required|string|max:29',
            'nama_kegiatan'     => 'required|string|min:5',
            'catatan'           => 'nullable|string'
        ]);
    }

    public function perjadinValidasi($data)
    {
        $trim = trim($data->availableBudget, ",-");
        $dots = str_replace(".", "", $trim);

        $data->validate([
            'tanggal_pengajuan' => 'required',
            'nota_dinas'        => 'required|string',
            'nama_kegiatan'     => 'required|string|min:5',
            'output'            => 'required',
            'account'           => 'required',
            'detail'            => 'required',
            'budget'            => 'required|numeric|max:' . intval($dots),
            'volume'            => 'required|numeric|lte:availableVolume',
            'tripList'          => 'required',
            'catatan'           => 'nullable|string'
        ]);
    }
}
