<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $label = 'Data Produk';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Select::make('id_kategori')
                ->relationship('kategori', 'nama_kategori')
                ->required(),
            TextInput::make('nama_produk')
                ->required()
                ->maxLength(255),
            TextInput::make('harga_beli')
                ->required()
                ->numeric()
                ->prefix('Rp'),
            TextInput::make('harga_jual')
                ->required()
                ->numeric()
                ->prefix('Rp'),
            TextInput::make('stok')
                ->required()
                ->numeric(),
            TextInput::make('barcode')
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori.nama_kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_beli')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('harga_jual')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('stok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('barcode')
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
