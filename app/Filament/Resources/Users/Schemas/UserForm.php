<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                Select::make('roles.name')->required()
                                    ->label('Role')
                                    ->relationship('roles', 'name')
                                    ->options(function () {
                                        return \App\Models\Role::pluck('name', 'id');
                                    })->searchable()->native()->saveRelationshipsUsing(function (Model $record, $state) {

                                        $record->roles()->syncWithPivotValues($state, [config('permission.column_names.team_foreign_key') => getPermissionsTeamId()]);
                                    }),
                                TextInput::make('password')
                                    ->password()
                                    ->revealable()
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),

            ]);
    }
}
