<?php

namespace App\Filament\Resources\LayananKiblats\Tables;

use App\Models\LayananKiblat;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\StatusLayanan;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;

class LayananKiblatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')->rowIndex(),
                TextColumn::make('nama_pemohon'),
                TextColumn::make('no_layanan')->copyable(),
                TextColumn::make('teamSatria.nama'),
                TextColumn::make('status_layanan_id'),
                SelectColumn::make('status_layanan_id')->label('status')->optionsRelationship(name: 'statusLayanan', titleAttribute: 'nama_status')->beforeStateUpdated(
                    function ($record, $state, $set, $livewire) {
                        if (empty($state)) {
                            return false;
                        }
                        $pesan = StatusLayanan::find($state)?->pesan;
                        $livewire->mountAction('message', [
                            'id' => $record->id,
                            'status' => $state,
                            'pesan' => $pesan,
                            'record' => $record,
                        ]);
                    }

                ),
                TextColumn::make('dokumen_pengajuan')->formatStateUsing(fn(string $state): string => $state == 'Belum Upload' ? "Belum Upload" : "Lihat Dokumen")
                    ->badge()
                    ->default('Belum Upload')->color(fn(string $state): string => match ($state) {
                        'Belum Upload' => 'danger',
                        $state => 'success'
                    })
                    ->action(
                        Action::make("Lihat Dokumen Pengajuan")->form([
                            AdvancedFileUpload::make('dokumen_pengajuan')->directory('dokumen_pengajuan')->downloadable()
                        ])->mountUsing(
                            function ($form, LayananKiblat $record) {
                                $form->fill([
                                    'dokumen_pengajuan' => $record->dokumen_pengajuan
                                ]);
                            }
                        )->modalWidth('4xl')->modalSubmitAction(false)->modalCancelAction(false)->disabled(fn(LayananKiblat $record): bool => !$record->dokumen_pengajuan)
                    ),
                TextColumn::make('dokumen_output')->formatStateUsing(fn(string $state): string => $state == 'Belum Upload' ? "Belum Upload" : "Lihat Dokumen")
                    ->badge()
                    ->default('Belum Upload')->color(fn(string $state): string => match ($state) {
                        'Belum Upload' => 'danger',
                        $state => 'success'
                    })
                    ->action(
                        Action::make("Lihat Dokumen Output")->form([
                            AdvancedFileUpload::make('dokumen_output')->directory('dokumen_output')->downloadable()
                        ])->mountUsing(
                            function ($form, LayananKiblat $record) {
                                $form->fill([
                                    'dokumen_output' => $record->dokumen_output
                                ]);
                            }
                        )->modalWidth('4xl')->modalSubmitAction(false)->modalCancelAction(false)->disabled(fn(LayananKiblat $record): bool => !$record->dokumen_output)
                    ),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
