<?php

namespace App\Filament\Resources\Solutions;

use App\Filament\Resources\Solutions\Pages\CreateSolution;
use App\Filament\Resources\Solutions\Pages\EditSolution;
use App\Filament\Resources\Solutions\Pages\ListSolutions;
use App\Filament\Resources\Solutions\Schemas\SolutionForm;
use App\Filament\Resources\Solutions\Tables\SolutionsTable;
use App\Models\Solution;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static ?string $modelLabel = 'Solusi Sistem';

    protected static ?string $pluralModelLabel = 'Solusi Sistem';

    protected static string|\UnitEnum|null $navigationGroup = 'Produk & Solusi';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedLightBulb;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return SolutionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SolutionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSolutions::route('/'),
            'create' => CreateSolution::route('/create'),
            'edit' => EditSolution::route('/{record}/edit'),
        ];
    }
}
