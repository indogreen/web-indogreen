<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Enums\InquiryStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tindak Lanjut & Status (Dapat Diedit)')
                    ->description('Ubah status proses inquiry dan tambahkan catatan koordinasi tim.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Status Inquiry')
                                    ->options(collect(InquiryStatus::cases())->mapWithKeys(
                                        fn (InquiryStatus $s) => [$s->value => $s->label()]
                                    )->all())
                                    ->required(),

                                TextInput::make('created_at')
                                    ->label('Waktu Masuk')
                                    ->disabled(),
                            ]),

                        Textarea::make('internal_notes')
                            ->label('Catatan Internal Tim Penjualan / Proyek')
                            ->rows(3)
                            ->placeholder('Tambahkan hasil kontak dengan calon klien, nomor penawaran, atau catatan teknis...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Pengirim & Pesan (Hanya Baca)')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('full_name')
                                    ->label('Nama Lengkap')
                                    ->disabled(),

                                TextInput::make('company_organization')
                                    ->label('Instansi / Perusahaan')
                                    ->disabled(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->label('Email')
                                    ->disabled(),

                                TextInput::make('phone_whatsapp')
                                    ->label('Nomor WhatsApp / Telepon')
                                    ->disabled(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('product_id')
                                    ->label('Produk Terkait')
                                    ->relationship('product', 'name')
                                    ->disabled(),

                                Select::make('solution_id')
                                    ->label('Solusi Terkait')
                                    ->relationship('solution', 'name')
                                    ->disabled(),
                            ]),

                        TextInput::make('subject')
                            ->label('Subjek Pesan')
                            ->disabled()
                            ->columnSpanFull(),

                        Textarea::make('message_content')
                            ->label('Isi Pesan Kebutuhan Proyek')
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('ip_address')
                                    ->label('Alamat IP')
                                    ->disabled(),

                                TextInput::make('user_agent')
                                    ->label('User Agent Peramban')
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }
}
