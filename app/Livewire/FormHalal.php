<?php

namespace App\Livewire;

use App\Models\LayananHalal;
use App\Models\TeamSatria;
use App\Notifications\WhatsAppNotification;
use Coderflex\LaravelTurnstile\Rules\TurnstileCheck;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Contracts\View\View;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class FormHalal extends Component implements HasSchemas
{
    use InteractsWithSchemas;
    public $no_layanan;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Layanan Sertifikasi Halal')->description('Assalamualaikum pengguna layanan terhormat.')
                    ->afterHeader(fn() => new HtmlString('<img  class="flex w-10" src="/Halal_indonesia.svg"/>'))
                    ->schema([
                        Select::make('team_satria_id')
                            ->label('Pilih Lokasi Layanan')
                            ->placeholder('Silahkan Pilih Layanan')
                            ->options(function () {
                                $locations = Location::get(request()->header('X-Forwarded-For') ?? request()->ip());
                                if (!$locations) {
                                    return TeamSatria::pluck('nama', 'id');
                                }

                                return TeamSatria::nearest($locations->latitude, $locations->longitude)->pluck('nama', 'id');
                            })
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nama} {$record->alamat}")
                            ->required()->native(false)->searchable(),
                        TextInput::make('nama_pemohon')
                            ->label('Nama Pemohon')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('no_hp')
                            ->label('No HP / Whatsapp')
                            ->tel()
                            ->required()
                            ->belowContent('Pastikan Nomor HP mempunyai akun Whatsapp')
                            ->maxLength(255),
                        Select::make('kabupaten_id')->label('Kabupaten/Kota')
                            ->options(
                                fn() => collect(static::getKabupaten())->pluck('name', 'id')
                            )
                            ->required()->native()->searchable()->live()->placeholder('Pilih Kabupaten'),
                        Select::make('kecamatan_id')->label('Kecamatan')
                            ->options(function (Get $get) {

                                $kabupaten = $get('kabupaten_id');
                                if (!$kabupaten) {
                                    return [];
                                }
                                return collect(static::getKecamatan($kabupaten))->pluck('name', 'id');
                            })
                            ->required()->native()->searchable()->live()->placeholder('Pilih Kecamatan'),
                    ]),
            ])
            ->statePath('data');
    }

    public function create(): void
    {

        $createLayanan =  LayananHalal::create(
            $this->form->getState()
        );
        if ($createLayanan) {
            $this->form->fill([]);
            $this->no_layanan  = $createLayanan->no_layanan;
            $this->dispatch('open-modal', id: 'user-info',);
            $whatsappnotif = new WhatsAppNotification('Terimakasih' . $createLayanan->nama_pemohon . 'Layanan Masuk Dengan Nomor Layanan :' . $createLayanan->no_layanan);
            $createLayanan->notify($whatsappnotif);
        }

        Notification::make('Sepertinya Ada Kesalahan')->icon('heroicon-o-exclamation-triangle');
    }

    public function render(): View
    {
        return view('livewire.form-halal');
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
}
