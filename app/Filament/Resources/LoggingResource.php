<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoggingResource\Pages;
use App\Filament\Resources\LoggingResource\RelationManagers;
use App\Models\Logging;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\View;
use Illuminate\Support\Str;

class LoggingResource extends Resource
{
    protected static ?string $model = Logging::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Logging';
    protected static ?string $navigationGroup = 'System';
    protected static ?string $slug = 'logging';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_name')
                    ->label('Pic')
                    ->required()
                    ->columnSpan(1)
                    ->disabled(),
                TextInput::make('resource')
                    ->label('Name')
                    ->required()
                    ->columnSpan(1)
                    ->disabled(),
                TextInput::make('action')
                    ->label('Action')
                    ->required()
                    ->columnSpan(2)
                    ->disabled(),
                DatePicker::make('created_at')
                    ->label('Created At')
                    ->columnSpan(1)
                    ->disabled(),
                DatePicker::make('updated_at')
                    ->label('Update At')
                    ->columnSpan(1)
                    ->disabled(),
                Section::make("Changes")
                    ->schema([
                        Textarea::make('old_data')
                            ->label('Old Data')
                            ->rows(10)
                            ->cols(50)
                            ->columnSpan(1)
                            ->afterStateHydrated(function (Textarea $component, $state) {
                                $component->state(json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                            })
                            ->disabled(),
                        Textarea::make('new_data')
                            ->label('New Data')
                            ->rows(10)
                            ->cols(50)
                            ->columnSpan(1)
                            ->disabled()
                            ->afterStateHydrated(function (Textarea $component, $state) {
                                $component->state(json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                            }),
                    ])->compact(),
            ]);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_name')
                    ->label('PIC')
                ->searchable(),
                TextColumn::make('resource')
                    ->label('Resource')
                    ->sortable(),
                TextColumn::make('action')
                    ->label('Action')
                    ->formatStateUsing(fn (string $state) => Str::title($state))
                    ->color(fn (string $state): string => match ($state) {
                        'create' => 'success',
                        'update' => 'info',
                    })
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([])
            ->bulkActions([]);
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
            'index' => Pages\ListLoggings::route('/'),
            'create' => Pages\CreateLogging::route('/create'),
            'edit' => Pages\EditLogging::route('/{record}/edit'),
        ];
    }
}
