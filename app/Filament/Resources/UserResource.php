<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationlabel ='Usuario';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Administración de usuarios';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Información Personal')
                ->columns(3)
                ->schema([
                // ...
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nombre')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->hiddenOn('edit')
                    ->required()
                    ->maxLength(255),
                ]),

                Section::make('Info dirección')
                ->columns(3)
                ->schema([
                    // ...
                    Forms\Components\Select::make('country_id')
                    ->relationship(name : 'country', titleAttribute:'name')
                    ->label('País')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('state_id',null);
                        $set('city_id', null);
                    })
                    ->required(),
                    Forms\Components\Select::make('state_id')
                    ->label('Región')
                    ->options(fn (Get $get): Collection => State::query()
                    ->where('country_id',$get('country_id'))
                    ->pluck('name','id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn  (Set $set) => $set('city_id',null))
                    ->required(),
                    Forms\Components\Select::make('city_id')
                    ->label('Ciudad')
                    ->options(fn (Get $get): Collection => City::query()
                    ->where('state_id',$get('state_id'))
                    ->pluck('name','id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                    Forms\Components\TextInput::make('address')
                    ->label('Dirección')
                    ->required(),
                    Forms\Components\TextInput::make('postal_code')
                    ->label('Código Postal')
                    ->required(),
                ]),
            ]);



    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:false),
                    Tables\Columns\TextColumn::make('postal_code')
                    ->label('Código Postal')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault:false),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault:true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
