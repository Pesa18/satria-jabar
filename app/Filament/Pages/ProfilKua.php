<?php

namespace App\Filament\Pages;

use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;

class ProfilKua extends Page implements HasSchemas
{
    use InteractsWithSchemas, HasPageShield;
    protected string $view = 'filament.pages.profil-kua';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';

    public ?array $dataForm = [];
    public bool $isEditing = false;

    // public static function canAccess(): bool
    // {
    //     return false;
    // }
    public function mount(): void
    {
        $kua = auth()->user()->kua()->first();

        if ($kua) {
            $this->form->fill([
                'dataForm' => $kua->toArray()
            ]);
        } else {
            $this->form->fill();
        }
    }

    public function getViewData(): array
    {

        return [
            'data' => auth()->user()->kua()->first(),
            'isEditing' => $this->isEditing
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(
                    'Profil KUA'
                )->schema(
                    [
                        TextInput::make('nama_kua')
                            ->label('Nama KUA')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()

                            ->maxLength(255),
                        TextInput::make('no_hp')
                            ->label('No. HP')
                            ->tel()

                            ->required()
                            ->maxLength(255),
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()

                            ->maxLength(255),
                        Select::make('kabupaten_id')
                            ->label('Kabupaten')
                            ->options(
                                fn() => collect(static::getKabupaten())->pluck('name', 'id')
                            )
                            ->native()

                            ->searchable()
                            ->live()
                            ->required(),
                        Select::make('kecamatan_id')
                            ->label('Kecamatan')

                            ->options(function (Get $get) {

                                $kabupaten = $get('kabupaten_id');
                                if (!$kabupaten) {
                                    return [];
                                }
                                return collect(static::getKecamatan($kabupaten))->pluck('name', 'id');
                            })
                            ->native()
                            ->searchable()
                            ->live()
                            ->required(),
                    ]
                )->columns(2)->statePath('dataForm')

            ]);
    }

    protected static function getKabupaten($id = '32')
    {
        try {
            $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/regencies/' . $id . '.json');
            $response->throw();

            return $response->json() ?? [];
        } catch (\Throwable $th) {
            return [];
        }
    }
    protected static function getKecamatan($id)
    {
        try {
            $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/districts/' . $id . '.json');
            $response->throw();
            return $response->json() ?? [];
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function save()
    {
        $data = $this->form->getState()['dataForm'] ?? [];
        $kua = auth()->user()->kua();
        if ($kua->exists()) {
            $kua->update($data);
            Notification::make()
                ->title('Berhasil Mengupdate Data')
                ->success()
                ->send();
        } else {
            $kua->create($data);
            Notification::make()
                ->title('Berhasil Mennyimpan Data')
                ->success()
                ->send();
        }
    }
}
