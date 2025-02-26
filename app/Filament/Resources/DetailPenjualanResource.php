<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailPenjualanResource\Pages;
use App\Filament\Resources\DetailPenjualanResource\RelationManagers;
use App\Models\DetailPenjualan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class DetailPenjualanResource extends Resource
{
    protected static ?string $model = DetailPenjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_penjualan')
                    ->relationship('penjualan', 'id')
                    ->required(),
                Select::make('id_produk')
                    ->relationship('produk', 'nama_produk')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, $get) =>
                        $set('harga_jual', \App\Models\Produk::find($state)?->harga_jual ?? 0)
                    ),
                TextInput::make('harga_jual')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),
                TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, $get) =>
                        $set('sub_total', $state * $get('harga_jual'))
                    ),
                TextInput::make('sub_total')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penjualan.id')
                    ->sortable()
                    ->label('No Transaksi'),
                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_jual')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('sub_total')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListDetailPenjualans::route('/'),
            'create' => Pages\CreateDetailPenjualan::route('/create'),
            'edit' => Pages\EditDetailPenjualan::route('/{record}/edit'),
        ];
    }
}
