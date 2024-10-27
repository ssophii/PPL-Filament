<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Transaksi;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\TextColumn;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal')
                    ->label('Hari Tanggal')
                    ->required()
                    ->displayFormat('d-m-Y') // Format tampilan di form
                    ->format('Y-m-d'),       // Format penyimpanan ke database
                
                Select::make('anggota_id')
                    ->relationship('anggota', 'nama')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('tipe')
                    ->options([
                        'Debit' => 'Debit',
                        'Kredit' => 'Kredit',
                    ]),

                TextInput::make('nominal')
                    ->label('Nominal')
                    ->numeric()
                    ->default(0)
                    ->required(),    

                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->required()
                    ->maxLength(255), 

                FileUpload::make('bukti')
                    ->label('Bukti')
                    ->nullable()                    
                    ->directory('bukti_transaksi')  
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf']) 
                    ->maxSize(2048),  
                
                Radio::make('konfirmasi')
                    ->label('Kas Anda Lunas?')
                    ->boolean()
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('id'),
                TextColumn::make('tanggal'),
                TextColumn::make('anggota.nama'),
                TextColumn::make('anggota.bidang'),
                TextColumn::make('tipe'),
                TextColumn::make('nominal'),
                TextColumn::make('keterangan'),
                TextColumn::make('bukti'),
                // TextColumn::make('konfirmasi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
