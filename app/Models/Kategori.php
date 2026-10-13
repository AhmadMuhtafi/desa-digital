<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'tipe',
        'nama',
        'slug',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'kategori_id');
    }

    public function potensiDesa(): HasMany
    {
        return $this->hasMany(PotensiDesa::class, 'kategori_id');
    }
}