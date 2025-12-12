<?php

namespace App\Filament\Resources\Submissions\Tables;

use App\Enum\SubmissionStatusEnum;
use App\Filament\Resources\Submissions\SubmissionResource;
use App\Models\Submission;
use Deldius\UserField\UserColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;

class SubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable(),
                TextColumn::make('uuid')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('receipt_number')
                    ->searchable(),
                UserColumn::make('user_id')
                    ->size(Size::Small)
                    ->label('User'),
                TextColumn::make('user.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('user.email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('user.phone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('admin.name')
                    ->label('Assigned to')
                    ->default('-'),
                TextColumn::make('note')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i:s', 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i:s', 'Asia/Jakarta')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->searchable([
                function (Builder $query, string $search): Builder {
                    if (! is_numeric($search)) {
                        return $query;
                    }

                    return $query
                        ->whereHas('user', function (Builder $query) use ($search) {
                            $query->where('phone_formatted', 'like', '%'.formatPhoneNumber($search).'%');
                        });
                },
            ])
            ->filters([
                \Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter::make('created_at')
                    ->timezone('Asia/Jakarta'),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('activities')->url(fn ($record) => SubmissionResource::getUrl('activities', ['record' => $record])),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                Action::make('assign_5')
                    ->label('Assign 5 to me')
                    ->action(function () {
                        $admin = auth('admin')->user();
                        $pendingSubmissions = Submission::where('admin_id', $admin->id)
                            ->orderBy('created_at', 'asc')
                            ->whereRelation('user', 'disqualified', false)
                            ->where('status', SubmissionStatusEnum::PENDING)
                            ->count();

                        if ($pendingSubmissions < 5) {
                            Submission::where('status', SubmissionStatusEnum::PENDING)
                                ->whereNull('admin_id')
                                ->whereRelation('user', 'disqualified', false)
                                ->take(max(0, 5 - $pendingSubmissions))
                                ->update(['admin_id' => $admin->id]);
                        }
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'assigned'),

                Action::make('assign_10')
                    ->label('Assign 10 to me')
                    ->action(function () {
                        $admin = auth('admin')->user();
                        $pendingSubmissions = Submission::where('admin_id', $admin->id)
                            ->orderBy('created_at', 'asc')
                            ->whereRelation('user', 'disqualified', false)
                            ->where('status', SubmissionStatusEnum::PENDING)
                            ->count();

                        if ($pendingSubmissions < 10) {
                            Submission::where('status', SubmissionStatusEnum::PENDING)
                                ->whereNull('admin_id')
                                ->whereRelation('user', 'disqualified', false)
                                ->take(max(0, 10 - $pendingSubmissions))
                                ->update(['admin_id' => $admin->id]);
                        }
                    })
                    ->visible(fn ($livewire) => $livewire->activeTab === 'assigned'),
                BulkActionGroup::make([
                    ExportBulkAction::make(),
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
