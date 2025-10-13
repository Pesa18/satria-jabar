<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Role;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

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

                                Select::make('role')
                                    ->relationship(name: 'roles', titleAttribute: 'name')

                                    ->saveRelationshipsUsing(function (Model $record, $state) {
                                        $record->roles()->syncWithPivotValues($state, [config('permission.column_names.team_foreign_key') => Filament::getTenant()->id]);
                                    })
                                    ->multiple()
                                    ->preload()
                                    ->searchable()->live(),
                                TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                                    ->revealable(),

                            ])->columns(2),
                    ])
                    ->columnSpanFull(),

            ]);
    }
}
