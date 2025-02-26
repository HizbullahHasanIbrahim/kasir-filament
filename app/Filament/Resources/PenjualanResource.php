<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Filament\Resources\PenjualanResource\RelationManagers;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
{
    return $form->schema([
        Select::make('id_user')
            ->relationship('user', 'name')
            ->required(),

        Select::make('id_pelanggan')
            ->relationship('pelanggan', 'nama')
            ->required(),

        TextInput::make('diskon')
            ->label('Diskon (%)')
            ->numeric()
            ->default(0)
            ->rules(['numeric', 'min:0', 'max:100'])
            ->live()
            ->afterStateUpdated(function ($state, $set, $get) {
                $total_harga = $get('total_harga');
                $set('total_harga', $total_harga * (1 - $state / 100));
            }),

        TextInput::make('total_harga')
            ->label('Total Harga')
            ->disabled()
            ->default(0),

        DatePicker::make('tanggal')
            ->label('Tanggal')
            ->required()
            ->default(now())
            ->dehydrated(),

        Repeater::make('detail_penjualan')
            ->label('Detail Produk')
            ->schema([
                TextInput::make('barcode')
                    ->label('Scan Barcode')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $produk = \App\Models\Produk::where('barcode', $state)->first();
                        if ($produk) {
                            if ($produk->stok > 0) {
                                $set('id_produk', $produk->id);
                                $set('harga_jual', $produk->harga_jual);
                                $set('nama_produk', $produk->nama_produk);
                                $set('stok_tersedia', $produk->stok);
                                $set('qty', 1); 
                                $set('sub_total', $produk->harga_jual * 1); 
                            } else {
                                Notification::make()
                                    ->warning()
                                    ->title('Stok Habis')
                                    ->body('Stok produk ini sedang kosong')
                                    ->send();
                            }
                        }
                    }),
                    
                Hidden::make('id_produk'),
                
                TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->disabled(),
                    
                TextInput::make('harga_jual')
                    ->label('Harga')
                    ->disabled()
                    ->numeric()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $qty = $get('qty');
                        $subtotal = $state * $qty;
                        $set('sub_total', $subtotal);
                        self::updateTotalHarga($set, $get);
                    }),
                    
                TextInput::make('stok_tersedia')
                    ->label('Stok Tersedia')
                    ->disabled(),
                    
                TextInput::make('qty')
                    ->label('Jumlah')
                    ->numeric()
                    ->default(1)
                    ->live()
                    ->rules(['required', 'numeric', 'min:1'])
                    ->afterStateUpdated(function ($state, $old, callable $set, $get) {
                        $harga = $get('harga_jual');
                        $qty = $state;
                        $stok = $get('stok_tersedia');
                        
                        if ($qty > $stok) {
                            $set('qty', $stok);
                            Notification::make()
                                ->warning()
                                ->title('Melebihi Stok')
                                ->body('Jumlah melebihi stok tersedia')
                                ->send();
                            $qty = $stok;
                        }
                        
                        $subtotal = $harga * $qty;
                        $set('sub_total', $subtotal);
                        self::updateTotalHarga($set, $get);
                    }),
                    
                TextInput::make('sub_total')
                    ->label('Subtotal')
                    ->disabled()
                    ->numeric()
                    ->default(0),
            ])
            ->live()
            ->afterStateUpdated(function ($state, $set, $get) {
                self::updateTotalHarga($set, $get);
            })
            ->columns(3),
        
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_pelanggan')
                ->label('Pelanggan')
                ->sortable()
                ->searchable()
                ->formatStateUsing(function ($state, Penjualan $penjualan) {
                    return $penjualan->pelanggan->nama; // Asumsi relasi 'pelanggan' ada di model Penjualan
                }),

            Tables\Columns\TextColumn::make('id_user')
                ->label('User')
                ->sortable()
                ->searchable()
                ->formatStateUsing(function ($state, Penjualan $penjualan) {
                    return $penjualan->user->name; // Asumsi relasi 'user' ada di model Penjualan
                }),

            Tables\Columns\TextColumn::make('diskon')
                ->label('Diskon (%)')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => $state . '%'),

            Tables\Columns\TextColumn::make('total_harga')
                ->label('Total Harga')
                ->sortable()
                ->searchable()
                ->money('IDR'), // Format sebagai mata uang Rupiah

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->sortable()
                ->searchable()
                ->date(), // Format sebagai tanggal
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }

    protected static function updateTotalHarga(callable $set, callable $get)
    {
    $total = collect($get('detail_penjualan'))->sum('sub_total');
    $set('total_harga', $total);
    
    $diskon = $get('diskon');
    $set('total_akhir', $total * (1 - $diskon / 100));
    }


}
