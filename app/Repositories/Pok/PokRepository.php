<?php

namespace App\Repositories\Pok;

use App\Models\Pok;
use App\Traits\GDriveUploadable;
use Asan\PHPExcel\Excel;
use Asan\PHPExcel\Reader\Xls;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PokRepository
{
    use GDriveUploadable;

    public function store($data) : string
    {
        try
        {
            DB::beginTransaction();

            $path = $this->pokUpload($data->pok);

            $reader = $this->initiateReader($path);

            $result = Pok::where('tahun', $data->tahun)->first('tahun');

            if (is_null($result)) {
                if (is_null($this->getCurrentPokYear())) {
                    // Pok tahun baru untuk unggah pertama kali
                    $this->storePokData($reader, $data->tahun, 0);
                } else {
                    // Pok tahun baru untuk unggah selanjutnya
                    $this->setPokStatus(intval($this->getCurrentPokYear()), false);

                    $this->storePokData($reader, $data->tahun, 0);
                }
            } else {
                // Untuk upload pok di tahun yang sama
                $this->setPokStatus($data->tahun, false);

                $result = $this->getPokVersion($data->tahun);

                $this->storePokData($reader, $data->tahun, ($result->revisi + 1), 'revisi');
            }

            $message = "Informasi POK telah disimpan.";

            DB::commit();
        } catch(Exception $error) {
            DB::rollBack();

            Log::alert($error->getMessage());

            $message = "Gagal menyimpan informasi POK.";
        }

        return $message;
    }

    private function initiateReader($path)
    {
        return Excel::load(public_path() . '/files/' . $path, function(Xls $reader) {
			$reader->setColumnLimit(10);
        });
    }

    private function getCurrentPokYear()
    {
        return Pok::max('tahun');
    }

    private function getPokVersion($year)
    {
        return Pok::query()
                  -> where('revisi', Pok::max('revisi'))
                  -> where('tahun', $year)
                  -> first('revisi');
    }

    private function setPokStatus(int $year, bool $state)
    {
        $result = Pok::query()
                     -> distinct('revisi')
                     -> where('tahun', $year)
                     -> get('revisi');

        $version = $result->max('revisi');

        Pok::query()
           -> where('tahun', $year)
           -> where('revisi', $version)
           -> update(['pakai' => $state]);
    }

    private function storePokData($reader, $year, $revision, $stage = null)
    {
        $x = 0;

        if($stage === 'revisi') {
            $oldPok = $this->getPreviousPok($year, $revision)->mapWithKeys(function($item) {
                return [$item['kd_kegiatan'] => $item['unit_id']];
            });

            foreach ($reader as $row) {
                if ($x > 0) {
                    if($row[1] === '(178-Mamuju)' || $row[1] === 'SULAWESI BARAT') continue;

                    // buang karakter ' dan spasi dari kolom kode
                    $kode    = trim($row[0]," '");

                    // hitung jumlah titik didalam string
                    $banyak	 = substr_count($kode, ".");

                    // hitung panjang karakter
                    $panjang = strlen($kode);

                    // undocumented
                    $masuk = 0;

                    if ($banyak > 0) {
                        $kod = explode(".", $kode);
                        if ($banyak == 2) {
                            if($kod[0] == '054') {
                                $kdDepartemen  = $kod[0];
                                $kdOrganisasi  = $kod[1];
                                $kdProgram	   = $kod[2];
                                $kdKegiatan	   = "0000";
                                $kdKro         = "000";
                                $kdRo          = "000";
                                $kdKomponen	   = "000";
                                $kdSubKomponen = "0";
                                $kdAkun		   = "000000";
                                $kdDetail	   = 0;
                                $masuk		   = 1;
                            } else {
                                $kdKegiatan    = $kod[0];
                                $kdKro         = $kod[1];
                                $kdRo          = $kod[2];
                                $kdKomponen	   = "000";
                                $kdSubKomponen = "0";
                                $kdAkun		   = "000000";
                                $kdDetail	   = 0;
                                $masuk		   = 1;
                            }
                        } elseif ($banyak == 1) {
                            $kdKro         = $kod[1];
                            $kdRo          = "000";
                            $kdKomponen	   = "000";
                            $kdSubKomponen = "0";
                            $kdAkun		   = "000000";
                            $kdDetail	   = 0;
                            $masuk		   = 1;
                        }
                    } else {
                        if ($panjang == 4) {
                            $kdKegiatan	   = $kode;
                            $kdKro	       = "000";
                            $kdRo          = "000";
                            $kdKomponen	   = "000";
                            $kdSubKomponen = "0";
                            $kdAkun		   = "000000";
                            $kdDetail	   = 0;
                        } elseif ($panjang == 3) {
                            $kdKomponen	   = $kode;
                            $kdSubKomponen = "0";
                            $kdAkun		   = "000000";
                            $kdDetail	   = 0;
                        } elseif($panjang == 1) {
                            $kdSubKomponen = $kode;
                            $kdAkun		   = "000000";
                            $kdDetail      = 0;
                        } elseif($panjang == 6) {
                            $kdAkun	  = $kode;
                            $kdDetail = 0;
                        } else {
                            $kdDetail += 1;
                        }

                        $masuk = 1;
                    }

                    if ($masuk == 1) {
                        $kdDetail > 0 ?
                            $description = ltrim(substr($row[1],(strpos($row[1],"-")+2),(strlen($row[1])-(strpos($row[1],"-")+2)))," ") :
                            $description = ltrim($row[1]," ");

                        $volume	     = trim($row[2], "'");
                        $tempvolume  = explode(" ", $volume);

                        $realvolume  = $tempvolume[0];
                        $satuan	     = $tempvolume[1];
                        $hargaSatuan = $row[3];
                        $total	     = $row[4];

                        Pok::create([
                            'tahun'          => $year,
                            'revisi'         => $revision,
                            'pakai'          => true,
                            'kd_departemen'  => $kdDepartemen,
                            'kd_organisasi'  => $kdOrganisasi,
                            'kd_program'     => $kdProgram,
                            'kd_kegiatan'    => $kdKegiatan,
                            'kd_kro'         => $kdKro,
                            'kd_ro'          => $kdRo,
                            'kd_komponen'    => $kdKomponen,
                            'kd_subkomponen' => $kdSubKomponen,
                            'kd_akun'        => $kdAkun,
                            'kd_detail'      => $kdDetail,
                            'deskripsi'      => $description,
                            'volume'         => !empty($realvolume) ? $realvolume : 0,
                            'satuan'         => $satuan,
                            'harga_satuan'   => !empty($hargaSatuan) ? $hargaSatuan : 0,
                            'total'          => $total,
                            'unit_id'        => $oldPok[$kdKegiatan] ?? null
                        ]);
                    }
                }

                $x += 1;
            }
        } else {
            foreach ($reader as $row) {
                if ($x > 0) {
                    if($row[1] === '(178-Mamuju)' || $row[1] === 'SULAWESI BARAT') continue;

                    // buang karakter ' dan spasi dari kolom kode
                    $kode    = trim($row[0]," '");

                    // hitung jumlah titik didalam string
                    $banyak	 = substr_count($kode, ".");

                    // hitung panjang karakter
                    $panjang = strlen($kode);

                    // undocumented
                    $masuk = 0;

                    $unitId = null;

                    if ($banyak > 0) {
                        $kod = explode(".", $kode);
                        if ($banyak == 2) {
                            if($kod[0] == '054') {
                                $kdDepartemen  = $kod[0];
                                $kdOrganisasi  = $kod[1];
                                $kdProgram	   = $kod[2];
                                $kdKegiatan	   = "0000";
                                $kdKro         = "000";
                                $kdRo          = "000";
                                $kdKomponen	   = "000";
                                $kdSubKomponen = "0";
                                $kdAkun		   = "000000";
                                $kdDetail	   = 0;
                                $masuk		   = 1;
                            } else {
                                $kdKegiatan    = $kod[0];
                                $kdKro         = $kod[1];
                                $kdRo          = $kod[2];
                                $kdKomponen	   = "000";
                                $kdSubKomponen = "0";
                                $kdAkun		   = "000000";
                                $kdDetail	   = 0;
                                $masuk		   = 1;
                            }
                        } elseif ($banyak == 1) {
                            $kdKro         = $kod[1];
                            $kdRo          = "000";
                            $kdKomponen	   = "000";
                            $kdSubKomponen = "0";
                            $kdAkun		   = "000000";
                            $kdDetail	   = 0;
                            $masuk		   = 1;
                        }
                    } else {
                        if ($panjang == 4) {
                            $kdKegiatan	   = $kode;
                            $kdKro	       = "000";
                            $kdRo          = "000";
                            $kdKomponen	   = "000";
                            $kdSubKomponen = "0";
                            $kdAkun		   = "000000";
                            $kdDetail	   = 0;
                        } elseif ($panjang == 3) {
                            $kdKomponen	   = $kode;
                            $kdSubKomponen = "0";
                            $kdAkun		   = "000000";
                            $kdDetail	   = 0;
                        } elseif($panjang == 1) {
                            $kdSubKomponen = $kode;
                            $kdAkun		   = "000000";
                            $kdDetail      = 0;
                        } elseif($panjang == 6) {
                            $kdAkun	  = $kode;
                            $kdDetail = 0;
                        } else {
                            $kdDetail += 1;
                        }

                        $masuk = 1;
                    }

                    if ($masuk == 1) {
                        $kdDetail > 0 ?
                            $description = ltrim(substr($row[1],(strpos($row[1],"-")+2),(strlen($row[1])-(strpos($row[1],"-")+2)))," ") :
                            $description = ltrim($row[1]," ");

                        $volume	     = trim($row[2], "'");
                        $tempvolume  = explode(" ", $volume);

                        $realvolume  = $tempvolume[0];
                        $satuan	     = $tempvolume[1];
                        $hargaSatuan = $row[3];
                        $total	     = $row[4];

                        Pok::create([
                            'tahun'          => $year,
                            'revisi'         => $revision,
                            'pakai'          => true,
                            'kd_departemen'  => $kdDepartemen,
                            'kd_organisasi'  => $kdOrganisasi,
                            'kd_program'     => $kdProgram,
                            'kd_kegiatan'    => $kdKegiatan,
                            'kd_kro'         => $kdKro,
                            'kd_ro'          => $kdRo,
                            'kd_komponen'    => $kdKomponen,
                            'kd_subkomponen' => $kdSubKomponen,
                            'kd_akun'        => $kdAkun,
                            'kd_detail'      => $kdDetail,
                            'deskripsi'      => $description,
                            'volume'         => !empty($realvolume) ? $realvolume : 0,
                            'satuan'         => $satuan,
                            'harga_satuan'   => !empty($hargaSatuan) ? $hargaSatuan : 0,
                            'total'          => $total,
                            'unit_id'        => null
                        ]);
                    }
                }

                $x += 1;
            }
        }
    }

    private function pokUpload($pokFile)
    {
        return $pokFile->storeAs('pok', 'pok-' . Carbon::now()->toDateString() . '_' . Str::random(5) . '.xls');
    }

    private function getPreviousPok($year, $revision)
    {
        return Pok::query()
                  -> where('tahun', $year)
                  -> where('revisi', ($revision - 1))
                  -> where('kd_program', '<>', '00')
                  -> where('kd_kegiatan', '<>', '0000')
                  -> where('kd_kro', '000')
                  -> where('kd_ro', '000')
                  -> where('kd_komponen', '000')
                  -> orderBy('id', 'asc')
                  -> get(['kd_kegiatan', 'unit_id']);
    }
}
