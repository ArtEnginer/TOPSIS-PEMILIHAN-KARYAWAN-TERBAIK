<?php

namespace App\Models\Topsis;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class HasilModel extends Model
{
    use HasUuids;

    protected $table = 'hasil';
    protected $fillable = [
        "alternatif_id",
        "nilai",
        "periode",
    ];

    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(AlternatifModel::class, 'alternatif_id', 'id');
    }
}
