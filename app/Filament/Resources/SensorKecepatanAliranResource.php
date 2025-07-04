<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use App\Models\SensorKecepatanAliran;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SensorKecepatanAliranResource\Pages;
use App\Filament\Resources\SensorKecepatanAliranResource\RelationManagers;

class SensorKecepatanAliranResource extends Resource
{
    protected static ?string $model = SensorKecepatanAliran::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup = 'Data Sensor';
    protected static ?string $label = 'Sensor Kecepatan Aliran';
    protected static ?string $pluralLabel = 'Sensor Kecepatan Aliran';
    protected static ?string $navigationBadgeTooltip = 'Jumlah Data';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_sensor')
                ->label('Nama Sensor')
                ->required()
                ->maxLength(100),

            TextInput::make('kecepatan_aliran')
                ->label('Nilai Kecepatan Aliran (M/L)')
                ->numeric()
                ->required(),

            DateTimePicker::make('waktu')
                ->label('Waktu Pendeteksian')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->state(function ($record, $livewire, $rowLoop) {
                        return ($livewire->getTableRecords()->currentPage() - 1) * $livewire->getTableRecords()->perPage() + $rowLoop->iteration;
                    }),
                Tables\Columns\TextColumn::make('nama_sensor')->label('Nama Sensor')->searchable(),
                Tables\Columns\TextColumn::make('kecepatan_aliran')->label('Nilai Kecepatan ALiran(M/L)')->sortable()->alignCenter(),
                Tables\Columns\TextColumn::make('waktu')->label('Waktu Pendeteksian')->dateTime()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->searchable()->alignCenter()->badge()->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'Lambat' => 'danger',
                        'Sedang' => 'warning',
                        'Cepat' => 'success'
                    }),
            ])
            ->filters([
                Filter::make('waktu')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('waktu', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('waktu', '<=', $data['until']));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['from']) {
                            $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['from'])->format('d M Y');
                        }

                        if ($data['until']) {
                            $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['until'])->format('d M Y');
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),

                BulkAction::make('download_csv')
                    ->label('Download CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($records) {
                        $filename = 'kecepatan_aliran_export_' . now()->format('Ymd_His') . '.csv';

                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"$filename\"",
                        ];

                        $callback = function () use ($records) {
                            $file = fopen('php://output', 'w');
                            fputcsv($file, ['Nama Sensor', 'Kecepatan Aliran', 'Waktu']);

                            foreach ($records as $record) {
                                fputcsv($file, [
                                    $record->nama_sensor,
                                    $record->kecepatan_aliran,
                                    $record->waktu,
                                ]);
                            }

                            fclose($file);
                        };

                        return response()->stream($callback, 200, $headers);
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSensorKecepatanAlirans::route('/'),
            'create' => Pages\CreateSensorKecepatanAliran::route('/create'),
            'edit' => Pages\EditSensorKecepatanAliran::route('/{record}/edit'),
        ];
    }
}
