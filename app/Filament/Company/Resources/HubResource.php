<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\HubResource\Pages;
use App\Filament\Company\Resources\HubResource\RelationManagers;
use App\Models\Hub;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HubResource extends Resource
{
    protected static ?string $model = Hub::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(191),
            Forms\Components\TextInput::make('latitude')
                ->required()
                ->maxLength(191),
            Forms\Components\TextInput::make('longitude')
                ->required()
                ->maxLength(191),
            Forms\Components\TextInput::make('connection')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('usage')
                ->required()
                ->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('latitude')
                ->searchable(),
            Tables\Columns\TextColumn::make('longitude')
                ->searchable(),
            Tables\Columns\TextColumn::make('connection')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('usage')
                ->numeric()
                ->sortable(),
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
            'index' => Pages\ListHubs::route('/'),
            'create' => Pages\CreateHub::route('/create'),
            'edit' => Pages\EditHub::route('/{record}/edit'),
        ];
    }
}
