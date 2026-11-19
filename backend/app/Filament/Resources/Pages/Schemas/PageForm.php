<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Halaman')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Halaman')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Dikosongkan jika dibuat otomatis dari judul halaman.')
                                    ->maxLength(255),
                            ]),

                        RichEditor::make('content')
                            ->label('Isi Konten')
                            ->helperText('HTML otomatis disanitasi saat disimpan.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan SEO & Status')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('seo_title')
                                    ->label('Judul SEO (Meta Title)')
                                    ->maxLength(60)
                                    ->helperText('Maksimal 60 karakter.'),

                                Textarea::make('seo_description')
                                    ->label('Deskripsi SEO (Meta Description)')
                                    ->maxLength(160)
                                    ->rows(2)
                                    ->helperText('Maksimal 160 karakter.'),
                            ]),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}
