<?php

namespace App\Filament\Resources\Users\Tables;

use Deldius\UserField\UserColumn;
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
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
