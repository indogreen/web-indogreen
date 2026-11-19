<?php

namespace App\Filament\Resources\Offices\Schemas;

use App\Enums\OfficeType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OfficeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kantor')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Kantor')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('office_type')
                                    ->label('Tipe Kantor')
                                    ->options(collect(OfficeType::cases())->mapWithKeys(
                                        fn (OfficeType $type) => [$type->value => $type->label()]
                                    )->all())
                                    ->required(),
                            ]),

                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->maxLength(50),

                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->maxLength(255),
                            ]),

                        Textarea::make('map_embed_url')
                            ->label('Embed URL Google Maps (iframe src)')
                            ->rows(2)
                            ->columnSpanFull()
                            ->helperText('Hanya masukkan atribut URL src dari embed Google Maps.'),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
}
