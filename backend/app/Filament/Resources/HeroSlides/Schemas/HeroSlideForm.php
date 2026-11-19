<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Slide')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Slide')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('subtitle')
                            ->label('Subjudul')
                            ->maxLength(255),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('button_text')
                                    ->label('Teks Tombol CTA')
                                    ->maxLength(50),

                                TextInput::make('button_url')
                                    ->label('Tautan Tombol CTA')
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                            ]),
                    ]),

                Section::make('Gambar Hero')
                    ->description('Format didukung: JPG, PNG, WebP. Maksimal 2MB per gambar.')
                    ->schema([
                        FileUpload::make('desktop_image')
                            ->label('Gambar Desktop')
                            ->image()
                            ->disk('public')
                            ->directory('hero_slides')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->helperText('Rekomendasi resolusi: 1920x800px.'),

                        FileUpload::make('mobile_image')
                            ->label('Gambar Mobile')
                            ->image()
                            ->disk('public')
                            ->directory('hero_slides')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->helperText('Rekomendasi resolusi: 768x1024px.'),
                    ]),
            ]);
    }
}
