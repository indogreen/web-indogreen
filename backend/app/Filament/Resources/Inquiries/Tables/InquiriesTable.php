<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Enums\InquiryStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('full_name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('company_organization')
                    ->label('Instansi / Perusahaan')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('phone_whatsapp')
                    ->label('WhatsApp')
                    ->searchable(),

                TextColumn::make('product.name')
                    ->label('Produk')
                    ->badge()
                    ->color('info')
                    ->placeholder('-'),

                TextColumn::make('solution.name')
                    ->label('Solusi')
                    ->badge()
                    ->color('warning')
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (InquiryStatus|string|null $state): string => match ($state instanceof InquiryStatus ? $state : ($state ? InquiryStatus::tryFrom($state) : null)) {
                        InquiryStatus::PENDING => 'danger',
                        InquiryStatus::CONTACTED => 'warning',
                        InquiryStatus::QUOTED => 'info',
                        InquiryStatus::CLOSED => 'success',
                        InquiryStatus::ARCHIVED => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn ($state): string => $state instanceof InquiryStatus ? $state->label() : ($state ?? '-')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Inquiry')
                    ->options(collect(InquiryStatus::cases())->mapWithKeys(
                        fn (InquiryStatus $s) => [$s->value => $s->label()]
                    )->all()),
            ])
            ->recordActions([
                EditAction::make()->label('Tinjau & Ubah Status'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
