<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $fillable = [
        'id_pelanggan',
        'id_user',
        'diskon',
        'total_harga',
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detail_penjualan(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }

}
