<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Http;

class ProfilP3h extends Page
{
    protected string $view = 'filament.pages.profil-p3h';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';
    public ?array $dataForm = [];
    public bool $isEditing = false;
    public function mount(): void
    {
        $p3h = auth()->user()->p3h()->first();

        if ($p3h) {
            $this->form->fill([
                'dataForm' => $p3h->toArray()
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
                    'Profil P3h'
                )->schema(
                    [
                        TextInput::make('nama_p3h')
                            ->label('Nama P3H')
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
        $p3h = auth()->user()->p3h();
        if ($p3h->exists()) {
            $p3h->update($data);
            Notification::make()
                ->title('Berhasil Mengupdate Data')
                ->success()
                ->send();
        } else {
            $p3h->create($data);
            Notification::make()
                ->title('Berhasil Mennyimpan Data')
                ->success()
                ->send();
        }
    }
}
