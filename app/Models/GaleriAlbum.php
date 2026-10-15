<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GaleriAlbum extends Model
{
    protected $table = 'galeri_album';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'judul',
        'deskripsi',
        'cover',
        'status',
    ];

    public function foto(): HasMany
    {
        return $this->hasMany(GaleriFoto::class, 'album_id');
    }
}
