<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Data Produk')
                    ->tabs([
                        Tab::make('Umum')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Produk')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Dikosongkan jika dibuat otomatis dari nama produk. URL stabil.')
                                            ->maxLength(255),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('category_id')
                                            ->label('Kategori')
                                            ->relationship('category', 'name')
                                            ->required()
                                            ->preload()
                                            ->searchable(),

                                        TextInput::make('model_series')
                                            ->label('Seri Model')
                                            ->placeholder('misal: Helios, Jupiter, Mars')
                                            ->required()
                                            ->maxLength(100),
                                    ]),

                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('badge_tag')
                                            ->label('Badge / Tag Khusus')
                                            ->placeholder('misal: Unggulan, TIO, AIO')
                                            ->maxLength(50),

                                        Toggle::make('is_featured')
                                            ->label('Produk Unggulan (Featured)')
                                            ->default(false),

                                        Toggle::make('is_active')
                                            ->label('Status Aktif')
                                            ->default(true),
                                    ]),

                                TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ]),

                        Tab::make('Spesifikasi')
                            ->icon('heroicon-o-table-cells')
                            ->schema([
                                Repeater::make('specifications')
                                    ->label('Daftar Parameter Spesifikasi Teknis')
                                    ->relationship('specifications')
                                    ->orderColumn('sort_order')
                                    ->defaultItems(0)
                                    ->schema([
                                        TextInput::make('spec_group')
                                            ->label('Grup Parameter')
                                            ->default('Umum')
                                            ->required(),

                                        TextInput::make('spec_key')
                                            ->label('Label Parameter')
                                            ->placeholder('misal: Daya Lampu, Kapasitas Baterai')
                                            ->required(),

                                        TextInput::make('spec_value')
                                            ->label('Nilai Parameter')
                                            ->placeholder('misal: 60W, 40Ah')
                                            ->required(),

                                        TextInput::make('spec_unit')
                                            ->label('Satuan')
                                            ->placeholder('W, V, Ah, K, lm')
                                            ->maxLength(50),
                                    ])
                                    ->columns(4)
                                    ->reorderable()
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => ($state['spec_key'] ?? null) ? "{$state['spec_key']}: {$state['spec_value']}" : null),
                            ]),

                        Tab::make('Fitur')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Textarea::make('short_description')
                                    ->label('Deskripsi Singkat / Ringkasan')
                                    ->rows(3)
                                    ->required()
                                    ->helperText('Ringkasan singkat yang ditampilkan pada kartu katalog produk.'),

                                RichEditor::make('full_description')
                                    ->label('Deskripsi Lengkap & Fitur')
                                    ->helperText('Konten lengkap produk. HTML otomatis disanitasi saat disimpan.'),
                            ]),

                        Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->label('Gambar Utama Produk')
                                    ->image()
                                    ->disk('public')
                                    ->directory('products/featured')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(2048)
                                    ->helperText('Format JPG, PNG, atau WebP. Maks 2MB.'),

                                FileUpload::make('datasheet_pdf')
                                    ->label('Brosur / Datasheet Teknis (PDF)')
                                    ->disk('public')
                                    ->directory('products/datasheets')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(10240)
                                    ->helperText('Format dokumen PDF. Maks 10MB.'),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('seo_title')
                                    ->label('Judul SEO (Meta Title)')
                                    ->maxLength(60)
                                    ->helperText('Maksimal 60 karakter. Digunakan untuk optimasi Google dan social share.'),

                                Textarea::make('seo_description')
                                    ->label('Deskripsi SEO (Meta Description)')
                                    ->maxLength(160)
                                    ->rows(3)
                                    ->helperText('Maksimal 160 karakter untuk snippet hasil pencarian mesin pencari.'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
