<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    protected $table = 'berita';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'penulis_id',
        'kategori_id',
        'judul',
        'slug',
        'isi',
        'gambar',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'penulis_id' => 'integer',
            'kategori_id' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
