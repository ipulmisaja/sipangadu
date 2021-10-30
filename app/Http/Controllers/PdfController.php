<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Pok;
use App\Models\PerjalananDinas;
use App\Models\Unit;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function generate($id)
    {
        $type = explode('-', $id);

        switch(getModelRelationship($id)['abbreviation'])
        {
            case 'LB' :
                $lembur = Lembur::where('reference_id', $id)->with(['pokRelationship', 'pemeriksaanRelationship'])->get();

                $data['nomor_spkl'] = $lembur[0]->nomor_spkl ?? '-';
                $data['nomor_nodis'] = $lembur[0]->nomor_pengajuan;
                $data['tanggal_spkl'] = $lembur[0]->tanggal_spkl ?? null;
                $data['tanggal_nodis'] = $lembur[0]->pemeriksaanRelationship->tanggal_pengajuan;
                $data['deskripsi'] = $lembur[0]->nama;
                $data['dasar_pelaksanaan'] = $lembur[0]->catatan;

                $data['kepala_approve'] = $lembur[0]->pemeriksaanRelationship->approve_kepala;
                $data['kepala_boss'] = User::whereHas("roles", function($q) { $q->where('name', 'kpa'); })->first(['nama', 'nip_id']);

                $parent_unit_id = (User::with('unitRelationship')->where('id', $lembur[0]->pemeriksaanRelationship->user_id)->first())->unitRelationship->parent;
                $data['kf_approve'] = $lembur[0]->pemeriksaanRelationship->approve_kf;
                $data['kf_boss'] = User::where('unit_id', $parent_unit_id)->first(['nama', 'nip_id']);
                $data['kf_unit'] = Unit::where('id', $parent_unit_id)->first('nama');


                $data['ppk_approve'] = $lembur[0]->pemeriksaanRelationship->approve_ppk;
                $data['ppk_boss'] = User::whereHas("roles", function($q) { $q->where('name', 'ppk'); })->first(['nama', 'nip_id']);

                $data['user_overtime'] = $lembur[0]->detailLemburRelationship;

                $pdf = PDF::loadView('components.template.overtime-proposal', $data)->setPaper('a4', 'portrait');

                return $pdf->stream();

                break;
            case 'PD' :
                $perjadin = PerjalananDinas::where('reference_id', $id)->with(['pokRelationship', 'pemeriksaanRelationship', 'detailPerjalananDinasRelationship'])->get();

                $data['nomor']    = $perjadin[0]->nomor_pengajuan;
                $data['fungsi']   = $this->getFungsi($perjadin);
                $data['program']  = $this->getProgram($perjadin);
                $data['kegiatan'] = $this->getKegiatan($perjadin);
                $data['output']   = $this->getOutput($perjadin);
                $data['komponen'] = $this->getKomponen($perjadin);
                $data['akun']     = $this->getAkun($perjadin);
                $data['detail']   = $perjadin[0]->nama;

                $data['row1col1'] = $perjadin[0]->catatan;
                $data['row1col2'] = $this->getTotal($perjadin);
                $data['row1col3'] = 0;
                $data['row1col4'] = $data['row1col2'] - $data['row1col3'];
                $data['row1col5'] = $perjadin[0]->total;
                $data['row1col6'] = $data['row1col4'] - $data['row1col5'];

                $data['row2col2'] = $data['row1col2'];
                $data['row2col3'] = $data['row1col3'];
                $data['row2col4'] = $data['row1col4'];
                $data['row2col5'] = $data['row1col5'];
                $data['row2col6'] = $data['row1col6'];

                $data['user_trip'] = $perjadin[0]->detailPerjalananDinasRelationship;

                $data['tanggal_pengajuan'] = $perjadin[0]->pemeriksaanRelationship->tanggal_pengajuan;

                $data['koordinator'] = $perjadin[0]->pemeriksaanRelationship->approve_kf;
                $data['nama_unit_koordinator'] = Unit::where('id', $perjadin[0]->pemeriksaanRelationship->userRelationship->unitRelationship->parent)->first('nama')->nama;
                $data['nama_unit_koordinator_boss'] = User::where('unit_id', $perjadin[0]->pemeriksaanRelationship->userRelationship->unitRelationship->parent)->first(['nama', 'nip_id']);

                $data['ppk'] = $perjadin[0]->pemeriksaanRelationship->approve_ppk;
                $data['ppk_boss'] = User::whereHas("roles", function($q) { $q->where('name', 'ppk'); })->first(['nama', 'nip_id']);

                $data['kpa'] = $perjadin[0]->pemeriksaanRelationship->approve_kepala;
                $data['kpa_boss'] = User::whereHas("roles", function($q) {$q->where('name', 'kpa'); })->first(['nama', 'nip_id']);

                $pdf = PDF::loadView('components.template.trip-proposal', $data)->setPaper('a4', 'portrait');

                return $pdf->stream();

                break;
            default:
        }
    }

    private function getFungsi($data) : string
    {
        $func = Unit::where('id', User::find($data[0]->pemeriksaanRelationship->user_id)->unitRelationship->parent)->first('nama')->nama;

        switch($func) {
            case 'Nerwilis':
                $tempfunct = 'Neraca Wilayah dan Analisis Statistik';
                break;
            case 'IPDS':
                $tempfunct = 'Integrasi Pengolahan dan Diseminasi Statistik';
                break;
            default:
                $tempfunct = $func;
        }

        return $tempfunct;
    }

    private function getProgram($data) : string
    {
        $type = $data[0]->pokRelationship->kd_program;

        switch($type) {
            case 'GG':
                $program = '(054.01.GG) Program Penyediaan dan Pelayanan Informasi Statistik';
                break;
            case 'WA':
                $program = '(054.01.WA) Program Dukungan Manajemen';
                break;
        }

        return $program;
    }

    private function getKegiatan($data) : string
    {
        $kegiatan = Pok::query()
                    -> where('pakai', $data[0]->pokRelationship->pakai)
                    -> where('kd_program', $data[0]->pokRelationship->kd_program)
                    -> where('kd_kegiatan', $data[0]->pokRelationship->kd_kegiatan)
                    -> where('kd_kro', '000')
                    -> first('deskripsi');

        return '(' . $data[0]->pokRelationship->kd_kegiatan . ')' . ' ' . $kegiatan->deskripsi;
    }

    private function getOutput($data) : string
    {
        $output = Pok::query()
                  -> where('pakai', $data[0]->pokRelationship->pakai)
                  -> where('kd_program', $data[0]->pokRelationship->kd_program)
                  -> where('kd_kegiatan', $data[0]->pokRelationship->kd_kegiatan)
                  -> where('kd_kro', '<>', '000')
                  -> where('kd_ro', $data[0]->pokRelationship->kd_ro)
                  -> where('kd_komponen', '000')
                  -> first('deskripsi');

        return '(' . $data[0]->pokRelationship->kd_kegiatan . '.' . $data[0]->pokRelationship->kd_kro . '.' . $data[0]->pokRelationship->kd_ro . ')' . ' ' .
                ucwords(strtolower($output->deskripsi));
    }

    private function getKomponen($data) : string
    {
        $komponen = Pok::query()
                    -> where('pakai', $data[0]->pokRelationship->pakai)
                    -> where('kd_program', $data[0]->pokRelationship->kd_program)
                    -> where('kd_kegiatan', $data[0]->pokRelationship->kd_kegiatan)
                    -> where('kd_kro', '<>', '000')
                    -> where('kd_ro', $data[0]->pokRelationship->kd_ro)
                    -> where('kd_komponen', $data[0]->pokRelationship->kd_komponen)
                    -> where('kd_akun', '000000')
                    -> first('deskripsi');

        return '(' . $data[0]->pokRelationship->kd_komponen . ')' . ' ' . ucwords(strtolower($komponen->deskripsi));
    }

    private function getAkun($data) : string
    {
        return '(' . $data[0]->pokRelationship->kd_akun . ')' . ' ' . $data[0]->pokRelationship->deskripsi;
    }

    private function getTotal($data)
    {
        $pagu = Pok::query()
                -> where('pakai', $data[0]->pokRelationship->pakai)
                -> where('kd_program', $data[0]->pokRelationship->kd_program)
                -> where('kd_kegiatan', $data[0]->pokRelationship->kd_kegiatan)
                -> where('kd_kro', '<>', '000')
                -> where('kd_ro', $data[0]->pokRelationship->kd_ro)
                -> where('kd_komponen', $data[0]->pokRelationship->kd_komponen)
                -> where('kd_akun', $data[0]->pokRelationship->kd_akun)
                -> where('kd_detail', '0')
                -> first('total');
        return $pagu->total;
    }
}
