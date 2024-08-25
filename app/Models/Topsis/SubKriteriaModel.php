<?php

namespace App\Models\Topsis;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Topsis\KriteriaModel;

class SubKriteriaModel extends Model
{
    use HasUuids;

    protected $table = 'subkriteria';
    protected $fillable = [
        "kriteria_id",
        "kode",
        "nama",
        "value",
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaModel::class, 'kriteria_id');
    }
}
