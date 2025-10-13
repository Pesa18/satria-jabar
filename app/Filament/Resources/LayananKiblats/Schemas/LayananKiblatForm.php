<?php

namespace App\Filament\Resources\LayananKiblats\Schemas;

use Carbon\Carbon;
use Filament\Schemas\Schema;
use App\Services\WilayahServices;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Asmit\FilamentUpload\Enums\PdfViewFit;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;

class LayananKiblatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pemohon')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('nama_pemohon')->required(),
                                TextInput::make('NIK'),
                                TextInput::make('no_hp'),
                                TextInput::make('email'),
                                DatePicker::make('tanggal_lahir')
                                    ->afterStateHydrated(
                                        function (Set $set, ?string $state,) {
                                            if ($state) {
                                                $set('umur', (int) Carbon::parse($state)->diffInYears(Carbon::now()) . ' Tahun');
                                            } else {
                                                $set('umur', null);
                                            }
                                        }
                                    )
                                    ->afterStateUpdated(
                                        function (Set $set, ?string $state,) {
                                            if ($state) {
                                                $set('umur', (int) Carbon::parse($state)->diffInYears(Carbon::now()) . ' Tahun');
                                            } else {
                                                $set('umur', null);
                                            }
                                        }
                                    )->live()->native(false),
                                TextInput::make('umur')->live()->disabled(),
                                Select::make('kabupaten_id')
                                    ->label('Kabupaten/Kota')
                                    ->extraInputAttributes([
                                        'style' => 'z-index: 9999; position: relative;',
                                    ])
                                    ->options(
                                        fn(WilayahServices $wilayah) =>  collect($wilayah->getKabupaten())->pluck('name', 'id')
                                    )
                                    ->required()->live()->searchable()->native(),
                                Select::make('kecamatan_id')
                                    ->label('Kecamatan')
                                    ->options(function (Get $get, WilayahServices $wilayah) {
                                        $kabupaten = $get('kabupaten_id');
                                        if (!$kabupaten) {
                                            return [];
                                        }
                                        return collect($wilayah->getKecamatan($kabupaten))->pluck('name', 'id');
                                    })->required()->native()->searchable()->live(),
                                Textarea::make('alamat_lengkap')
                            ])->columns(2)
                    ])->columnSpanFull()->collapsible(),

                Section::make('Data Layanan')->schema([
                    Group::make()->schema([
                        TextInput::make('no_layanan')->readOnly()->copyable(),
                        Select::make('jenis_layanan')
                            ->options([
                                'id_masjid' => 'ID Masjid',
                                'perubahan_data' => 'Perubahan Data',
                            ])->required(),
                        TextInput::make('nama_masjid'),
                        TextInput::make('alamat_masjid'),
                    ])->columns(2),
                    Group::make()->schema([
                        FileUpload::make('foto_pelayanan')
                            ->directory('foto_layanan')
                            ->image()
                            ->maxSize(1024),
                        Textarea::make('catatan'),
                    ])->columns(2),

                ])->columnSpanFull()->collapsible(),
                Section::make('Dokumen Pengajuan')->schema([
                    AdvancedFileUpload::make('dokumen_pengajuan')
                        ->directory('dokumen_pengajuan')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(1024)
                        ->pdfPreviewHeight(400)
                        ->pdfZoomLevel(100)
                        ->pdfDisplayPage(1) // Set default page
                        ->pdfToolbar(true)
                        ->downloadable()
                        ->pdfNavPanes(true)
                        ->pdfFitType(PdfViewFit::FIT)
                ])->columnSpanFull()->collapsible()->collapsed(),
                Section::make('Dokumen Layanan')->schema([
                    AdvancedFileUpload::make('dokumen_output')
                        ->directory('dokumen_output')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(1024)
                        ->pdfPreviewHeight(400)
                        ->pdfZoomLevel(100)
                        ->pdfDisplayPage(1) // Set default page
                        ->pdfToolbar(true)
                        ->downloadable()
                        ->pdfNavPanes(true)
                ])->columnSpanFull()->collapsible()->collapsed(),
            ]);
    }
}
