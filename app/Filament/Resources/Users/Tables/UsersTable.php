<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Deldius\UserField\UserColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webbingbrasil\FilamentCopyActions\Tables\CopyableTextColumn;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                UserColumn::make('id')
                    ->size(Size::Small) // Set avatar size
                    ->label('User')// Column label
                ,
                // TextColumn::make('name')
                //     ->toggleable(isToggledHiddenByDefault: true)
                //     ->searchable(),
                CopyableTextColumn::make('email')
                    ->label('Email address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                CopyableTextColumn::make('phone'),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('phone_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i:s', 'GMT+7')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i:s', 'GMT+7')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('unDisqualify')
                    ->label('Un disqualify user')
                    ->action(function (User $record) {
                        $record->disqualified = false;
                        $record->save();
                    })
                    ->disabled(fn (User $record) => ! $record->disqualified)
                    ->hidden(fn (User $record) => ! $record->disqualified)
                    // ->icon('heroicon-check')
                    ->color('success')
                    ->requiresConfirmation()

                    ->modalHeading(function (User $record) {
                        return 'Un disqualify user '.$record->name;
                    })
                    ->modalDescription(function (User $record) {
                        return 'Are you sure you want to un disqualify '.$record->name.'?';
                    })
                    ->modalSubmitActionLabel('Un disqualify user'),

                Action::make('disqualify')
                    ->label('Disqualify user')
                    ->action(function (User $record) {
                        $record->disqualified = true;
                        $record->save();
                    })
                    ->disabled(fn (User $record) => $record->disqualified)
                    ->hidden(fn (User $record) => $record->disqualified)
                    // ->icon('heroicon-exclamation')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(function (User $record) {
                        return 'Disqualify user '.$record->name;
                    })
                    ->modalDescription(function (User $record) {
                        return 'Are you sure you want to disqualify '.$record->name.'?';
                    })
                    ->modalSubmitActionLabel('Disqualify user'),

                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])
            ->searchable(['name', 'email', 'phone'])
            ->searchPlaceholder('Search (Name, Email, Phone)');

    }
}
