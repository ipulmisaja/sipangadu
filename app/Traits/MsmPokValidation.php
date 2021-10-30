<?php

namespace App\Traits;

trait MsmPokValidation
{
    /**
     * Validasi pemeriksaan MSM
     *
     * @param mixed $data
     * @return void
     */
    public function validateInspection($data)
    {
        $data->validate([
            'approval_state' => 'required',
            'comment'        => 'required|string|min:5'
        ]);
    }
}
