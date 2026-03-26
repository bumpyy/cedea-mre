<?php

namespace App\Filament\Resources\SubmissionAreas;

// use App\Filament\Resources\SubmissionAreas\Pages\CreateSubmissionArea;
use App\Enum\SubmissionStatusEnum;
use App\Filament\Resources\SubmissionAreas\Pages\EditSubmissionArea;
use App\Filament\Resources\SubmissionAreas\Pages\ListSubmissionAreas;
use App\Filament\Resources\SubmissionAreas\Schemas\SubmissionAreaForm;
use App\Filament\Resources\SubmissionAreas\Tables\SubmissionAreasTable;
use App\Models\Submission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubmissionAreaResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Submission Area';

    protected static ?string $navigationLabel = 'Edit submission area';

    protected static ?string $slug = 'submission-area';

    public static function form(Schema $schema): Schema
    {
        return SubmissionAreaForm::configure($schema);

    }

    public static function table(Table $table): Table
    {
        return SubmissionAreasTable::configure($table)
            ->modifyQueryUsing(fn (Builder $query) => $query->where(function ($query) {
                return $query
                    ->where('status', SubmissionStatusEnum::ACCEPTED)
                    ->whereHas('user', function ($query) {
                        $query->where('disqualified', false);
                    })
                    ->whereNull('store_area')
                    ->orWhere('store_area', '');
            }));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubmissionAreas::route('/'),
            // 'create' => CreateSubmissionArea::route('/create'),
            'edit' => EditSubmissionArea::route('/{record}/edit'),
        ];
    }
}
