<?php

namespace App\Traits;

include public_path('template/PHPExcel/PHPExcel/IOFactory.php');

use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Ipulmisaja\Macoa\Helpers\DateFormat;
use PHPExcel_IOFactory;

trait GenerateDocument
{
    public function letterOfAssignment($referenceId)
    {
        $inputFileName = public_path('template/template_spd.xlsx');

        $trip = Trip::with(['tripDetailRelationship', 'pokRelationship', 'activityRelationship'])->where('reference_id', $referenceId)->get();

        $reader =  PHPExcel_IOFactory::load($inputFileName);

        $spreadsheet = $reader->getSheetByName('Data SPD');

        foreach($trip[0]->tripDetailRelationship as $i => $item)
        {
            // Nomor Pegawai
            $spreadsheet->setCellValue('B'.($i+3), $item->user_id);

            // Tanggal Surat
            $spreadsheet->setCellValue('C'.($i+3), $item->mail_number);

            // Bulan Romawi Manual Saja Isinya
            // Tujuan
            $spreadsheet->setCellValue('J'.($i+3), strip_tags($trip[0]->note));

            // Alat Angkutan
            $kendaraan = $item->userRelationship->hasRole(['kpa', 'koordinator']);
            $spreadsheet->setCellValue('K'.($i+3), $kendaraan ? 'Kendaraan Dinas' : 'Kendaraan Umum');

            // Kota Tujuan
            $spreadsheet->setCellValue('M'.($i+3), $item->destination);

            // Waktu
            $spreadsheet->setCellValue('N'.($i+3), Carbon::parse($item->end_date, 'UTC')->diffInDays(Carbon::parse($item->start_date, 'UTC')) + 1);

            // Tanggal Berangkat
            $spreadsheet->setCellValue('O'.($i+3), DateFormat::convertDateTime($item->start_date));

            // Tanggal Kembali
            $spreadsheet->setCellValue('P'.($i+3), DateFormat::convertDateTime($item->end_date));

            // Program
            $spreadsheet->setCellValue('R'.($i+3), $trip[0]->pokRelationship->kd_departemen . '.' . $trip[0]->pokRelationship->kd_organisasi . '.' . $trip[0]->pokRelationship->kd_program);

            // Kegiatan/Output/Komponen
            $spreadsheet->setCellValue('S'.($i+3), $trip[0]->pokRelationship->kd_kegiatan . '.' . $trip[0]->pokRelationship->kd_kro . '.' . $trip[0]->pokRelationship->kd_ro . '.' . $trip[0]->pokRelationship->kd_komponen);

            // Akun
            $spreadsheet->setCellValue('T'.($i+3), $trip[0]->pokRelationship->kd_akun);
        }

        $writer = PHPExcel_IOFactory::createWriter($reader, 'Excel2007');

        $writer->save(public_path('files/document/surat_tugas.xlsx'));
    }
}
