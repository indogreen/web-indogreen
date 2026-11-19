<?php

namespace App\Filament\Resources\Solutions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SolutionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('diagram_image')
                    ->label('Diagram')
                    ->disk('public'),

                TextColumn::make('name')
                    ->label('Nama Solusi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('system_type')
                    ->label('Tipe Sistem')
                    ->badge()
                    ->color('warning')
                    ->searchable(),

                TextColumn::make('products_count')
                    ->label('Produk Terkait')
                    ->counts('products')
                    ->badge(),

                ToggleColumn::make('is_active')
                    ->label('Aktif'),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
