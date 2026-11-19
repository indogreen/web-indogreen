<?php

namespace App\Filament\Resources\Solutions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SolutionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama Solusi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Solusi')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Dikosongkan jika dibuat otomatis dari nama solusi.')
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('system_type')
                                    ->label('Tipe Sistem EBT')
                                    ->placeholder('misal: On-Grid, Off-Grid, Hybrid, PJU TIO, SHS')
                                    ->required()
                                    ->maxLength(100),

                                Select::make('products')
                                    ->label('Produk Terkait')
                                    ->relationship('products', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->helperText('Pilih produk-produk yang digunakan dalam paket solusi ini.'),
                            ]),

                        Textarea::make('summary')
                            ->label('Ringkasan Eksekutif Solusi')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),

                        RichEditor::make('system_architecture')
                            ->label('Arsitektur Sistem & Cara Kerja')
                            ->helperText('Penjelasan teknis aliran daya dan instalasi. HTML otomatis disanitasi.')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TagsInput::make('included_components')
                                    ->label('Komponen yang Termasuk (BOM)')
                                    ->placeholder('Ketik komponen lalu tekan Enter')
                                    ->helperText('Daftar modul surya, inverter, baterai, wiring, dll.'),

                                TagsInput::make('benefits')
                                    ->label('Keuntungan / Manfaat Utama')
                                    ->placeholder('Ketik manfaat lalu tekan Enter')
                                    ->helperText('Manfaat ekonomi, keandalan, dan efisiensi energi.'),
                            ]),
                    ]),

                Section::make('Media Diagram & Gambar')
                    ->schema([
                        FileUpload::make('diagram_image')
                            ->label('Diagram Alur / Gambar Topologi')
                            ->image()
                            ->disk('public')
                            ->directory('solutions/diagrams')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->helperText('Format JPG, PNG, WebP, atau SVG. Maksimal 2MB.'),
                    ]),

                Section::make('Pengaturan SEO & Visibilitas')
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

                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
}
