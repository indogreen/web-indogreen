<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun Pengguna')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('password')
                                    ->label('Kata Sandi')
                                    ->password()
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->helperText('Kosongkan jika tidak ingin mengubah kata sandi.'),

                                Select::make('roles')
                                    ->label('Peran (Role)')
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->required()
                                    ->helperText('Menentukan hak akses menu dan resource pada panel admin.')
                                    ->rules([
                                        function ($record) {
                                            return function (string $attribute, mixed $value, Closure $fail) use ($record) {
                                                if ($record instanceof User && $record->hasRole('admin')) {
                                                    $selectedRoles = is_array($value) ? $value : [];
                                                    $adminRole = Role::where('name', 'admin')->first();
                                                    $hasAdmin = in_array('admin', $selectedRoles, true)
                                                        || ($adminRole && in_array($adminRole->id, $selectedRoles, false));

                                                    if (! $hasAdmin && User::role('admin')->count() <= 1) {
                                                        $fail('Peran admin tidak dapat dicabut dari administrator terakhir.');
                                                    }
                                                }
                                            };
                                        },
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
