<?php

namespace App\Models\Topsis;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Topsis\KriteriaModel;
use App\Models\Topsis\SubKriteriaModel;
use App\Models\Topsis\AlternatifModel;


class PenilaianModel extends Model
{
    use HasUuids;

    protected $table = 'penilaian';
    protected $fillable = [
        "alternatif_id",
        "kriteria_id",
        "subkriteria_id",
        "periode",
    ];

    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(AlternatifModel::class, 'alternatif_id');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id');
    }

    public function subkriteria(): BelongsTo
    {
        return $this->belongsTo(SubKriteriaModel::class, 'subkriteria_id');
    }
}
