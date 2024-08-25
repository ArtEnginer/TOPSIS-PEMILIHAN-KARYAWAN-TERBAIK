<?php

namespace App\Models\Topsis;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KriteriaModel extends Model
{
    use HasUuids;

    protected $table = 'kriteria';
    protected $fillable = [
        "kode",
        "nama",
        "bobot",
    ];

    public function subkriteria(): HasMany
    {
        return $this->hasMany(SubkriteriaModel::class, 'kriteria_id');
    }
}
