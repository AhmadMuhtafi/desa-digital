<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'kategori_id',
        'judul',
        'file',
        'tipe_file',
        'jumlah_unduh',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'kategori_id' => 'integer',
            'jumlah_unduh' => 'integer',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
