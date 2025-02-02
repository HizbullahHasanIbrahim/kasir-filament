<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

    protected $fillable = [
        'nama',
        'alamat',
        'hp'
    ];

    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan');
    }
}
