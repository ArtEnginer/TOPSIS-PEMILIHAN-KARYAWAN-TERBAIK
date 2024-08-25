<?php

namespace App\Models\Topsis;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Topsis\PenilaianModel;

class AlternatifModel extends Model
{
    use HasUuids;

    protected $table = 'alternatif';
    protected $fillable = [
        "kode",
        "nama",
        "nip",
        "tempat_lahir",
        "tanggal_lahir",
        "bidang_tugas",
    ];

    public function penilaian(): HasMany
    {
        return $this->hasMany(PenilaianModel::class, 'alternatif_id');
    }
}
