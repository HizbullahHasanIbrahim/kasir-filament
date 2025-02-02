<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'harga_beli',
        'harga_jual',
        'stok',
        'barcode'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function detailPenjualans(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'id_produk');
    }
}
