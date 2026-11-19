<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Peran')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Peran')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled(fn (?Role $record): bool => $record?->name === 'admin')
                            ->helperText('Peran "admin" adalah peran sistem dan namanya tidak dapat diganti.')
                            ->maxLength(255),

                        CheckboxList::make('permissions')
                            ->label('Hak Izin (Permissions)')
                            ->relationship('permissions', 'name')
                            ->columns(2)
                            ->required()
                            ->helperText('Pilih izin-izin yang diberikan kepada pemegang peran ini.'),
                    ]),
            ]);
    }
}
