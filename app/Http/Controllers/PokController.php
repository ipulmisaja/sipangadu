<?php

namespace App\Http\Controllers;

use App\Models\Pok;
use Illuminate\Http\Request;

class PokController extends Controller
{
    public function store(Request $request)
    {
        foreach($request->func_coord as $value)
        {
            if($value === "pilih") continue;

            $kf_temp = explode('.', $value);

            for ($i = 0; $i < Pok::where('kd_kegiatan', $kf_temp[1])->count(); $i++) {
                Pok::query()
                    -> where('pakai', true)
                    -> where('kd_program', $kf_temp[0])
                    -> where('kd_kegiatan', $kf_temp[1])
                    -> update(['unit_id' => $kf_temp[2]]);
            }
        }

        return redirect('kertas-kerja/alokasi-anggaran')->with('message', 'Alokasi anggaran telah dilakukan.');
    }
}
