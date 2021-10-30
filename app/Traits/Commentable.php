<?php

namespace App\Traits;

use App\Models\Komentar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

trait Commentable
{
    public function getComment($model)
    {
        $result = Komentar::where('reference_id', $model->reference_id)->get();

        return $result;
    }

    public function setComment($model, $status, $comment, $role)
    {
        Komentar::create([
            'reference_id'     => $model->reference_id,
            'komentator_id'    => Auth::user()->id,
            'komentator_tipe'  => Role::where('name', $role)->first('id')->id,
            'status'           => $status,
            'deskripsi'        => $comment,
            'tanggal_komentar' => Carbon::now()
        ]);
    }
}
