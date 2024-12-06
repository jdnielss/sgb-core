<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SecurityReportResource\Pages;
use App\Filament\Resources\SecurityReportResource\RelationManagers;
use App\Models\SecurityReport;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SecurityReportResource extends Resource
{
    protected static ?string $model = SecurityReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Report';
    protected static ?string $navigationGroup = 'Admin';
    protected static ?string $slug = 'security-report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('affected_user_name')
                        ->label('Affected User')
                        ->required(),
                    TextInput::make('facebook_link')
                        ->label('Facebook Link')
                        ->required(),
                    TextInput::make('executed_by')
                        ->label('Executor')
                        ->required(),
                    DatePicker::make('executed_at')
                        ->label('Execute Date')
                        ->required(),
                    Select::make('action_type')
                        ->label("Action Type")
                        ->required()
                        ->columnSpan("full")
                        ->options([
                            'rejoin' => 'Rejoin',
                            'muted' => 'Muted',
                            'banned' => 'Banned',
                        ]),
                    FileUpload::make('attachment')
                        ->acceptedFileTypes(['image/*'])
                        ->downloadable()
                        ->maxSize(1024)
                        ->required()
                    ->columnSpan('full')
                ])->columns(2),
                Section::make()->schema([
                    Textarea::make('notes')
                        ->label('Notes')
                        ->required()
                        ->rows(10)
                        ->cols(50)
                        ->columnSpan(2)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No. ')
                    ->rowIndex(),
                TextColumn::make('affected_user_name')
                    ->label('Affected User')
                    ->searchable(),
                TextColumn::make('facebook_link')
                    ->label('Facebook')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('executed_by')
                    ->label('Executed By'),
                TextColumn::make('executed_at')
                    ->label('Executed Date')
                    ->sortable(),
                TextColumn::make('action_type')
                    ->label('Action Type')
                    ->formatStateUsing(fn (string $state) => Str::title($state))
                    ->color(fn (string $state): string => match ($state) {
                        'rejoin' => 'success',
                        'muted' => 'gray',
                        'banned' => 'danger',
                        default => 'info',
                    })
                    ->badge()
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSecurityReports::route('/'),
            'create' => Pages\CreateSecurityReport::route('/create'),
            'edit' => Pages\EditSecurityReport::route('/{record}/edit'),
        ];
    }
}
