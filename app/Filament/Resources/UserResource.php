<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Menu';

    protected static ?string $navigationBadgeTooltip = 'Jumlah User';

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->validationAttribute('name'),

                TextInput::make('no_telepon')
                    ->label('No Telepon')
                    ->tel()
                    ->nullable()
                    ->validationAttribute('no_telpon'),

                TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->validationAttribute('email'),

                Select::make('role')
                    ->label('Role')
                    ->options(Role::all()->pluck('name', 'name'))
                    ->afterStateHydrated(function ($component, $record) {
                        if ($record) {
                            $component->state($record->roles->pluck('name')->first());
                        }
                    })
                    ->dehydrated(true)
                    ->required()
                    ->afterStateUpdated(function ($state, $get, $set, $record) {
                        if ($record) {
                            $record->syncRoles([$state]);
                        }
                    }),

                TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                    ->dehydrated(fn($state) => filled($state))
                    ->validationAttribute('password'),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->rows(3)
                    ->nullable(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->state(fn($record, $livewire, $rowLoop) => ($rowLoop->iteration + ($livewire->getTableRecords()->perPage() * ($livewire->getTableRecords()->currentPage() - 1)))),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('no_telepon')->label('Telepon'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('alamat')->limit(30),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')->sortable()->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'warning',
                        'pengguna' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => ucwords(strtolower($state))),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        Notification::make()
                            ->title('User Dihapus')
                            ->body("User <strong>{$record->name}</strong> telah berhasil dihapus.")
                            ->success()
                            ->sendToDatabase(auth()->user());
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user?->hasRole('admin') ?? false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
