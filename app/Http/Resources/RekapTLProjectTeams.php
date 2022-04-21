<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RekapTLProjectTeams extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "project_jabatan_id" => $this->project_jabatan_id,
            "project_kota_id" => $this->project_kota_id,
            "team_id" => $this->team_id,
            "gaji" => $this->gaji,
            "denda" => $this->denda,
            "user_id" => $this->user_id,
            "type_tl" => $this->type_tl,
            "team_leader" => $this->team_leader,
            "target_tl" => $this->target_tl,
            "srvyr" => $this->srvyr_tl,
            "nama" => $this->team->nama,
            "alamat" =>$this->team->alamat,
            "hp" => $this->team->hp,
            "email" => $this->team->email,
            "kode_bank" => $this->team->kode_bank,
            "nomor_rekening" => $this->team->nomor_rekening,
            "no_team" => $this->team->no_team,
            "kota_id" => $this->team->kota_id,
            "kota" => $this->projectKota->kota->kota,
        ];
    }
}
