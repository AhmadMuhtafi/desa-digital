<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakDesa extends Model
{
    protected $table = 'kontak_desa';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'alamat',
        'telepon',
        'jam_pelayanan',
        'latitude',
        'longitude',
        'radius_meter',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'radius_meter' => 'integer',
        ];
    }
}