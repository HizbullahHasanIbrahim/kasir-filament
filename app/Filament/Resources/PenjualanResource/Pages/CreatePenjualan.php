<?php

namespace App\Filament\Resources\PenjualanResource\Pages;

use App\Filament\Resources\PenjualanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\DetailPenjualan;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function afterCreate(): void
    {
        $penjualan = $this->record;
        
        // Ambil data detail_penjualan dari form
        $details = $this->data['detail_penjualan'] ?? [];
        
        // Simpan setiap detail penjualan
        foreach ($details as $detail) {
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id,
                'id_produk' => $detail['id_produk'],
                'harga_jual' => $detail['harga_jual'],
                'qty' => $detail['qty'],
                'sub_total' => $detail['sub_total'],
            ]);
        }
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hapus detail_penjualan dari data karena akan disimpan terpisah
        unset($data['detail_penjualan']);
        
        return $data;
    }
}