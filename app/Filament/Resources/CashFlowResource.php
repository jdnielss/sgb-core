<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashFlowResource\Pages;
use App\Models\CashFlow;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Forms\Components\{DatePicker, FileUpload, Textarea, TextInput};
use Filament\Tables\Actions\{EditAction, BulkActionGroup, DeleteBulkAction};
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Filament\Tables\Columns\{TextColumn, DateColumn};

class CashFlowResource extends Resource
{
    protected static ?string $model = CashFlow::class;
    protected static ?string $navigationLabel = 'Cash Flow';
    protected static ?string $navigationGroup = 'Admin';
    protected static ?string $slug = 'cash-flow';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->columnSpan(2),

                DatePicker::make('transaction_date')
                    ->label('Transaction Date')
                    ->required()
                    ->columnSpan('full'), // Spans full width on mobile

                TextInput::make('expenses')
                    ->label('Expenses')
                    ->prefix("Rp. ")
                    ->minValue(0)
                    ->numeric()
                    ->required()
                    ->columnSpan(1), // Takes half width on larger screens

                TextInput::make('income')
                    ->label('Income')
                    ->prefix("Rp. ")
                    ->minValue(0)
                    ->numeric()
                    ->required()
                    ->columnSpan(1), // Takes half width on larger screens

                    Textarea::make('notes')
                        ->label('Notes')
                        ->maxLength(255)
                        ->rows(10)
                        ->cols(20)
                        ->columnSpan('full'), // Spans full width on mobile

                FileUpload::make('attachment')
                    ->label('Attachment')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(1024)
                    ->required()
                    ->columnSpan('full'), // Spans full width on mobile

                PdfViewerField::make('attachment')
                    ->label('View the PDF')
                    ->minHeight('100svh')
                    ->columnSpan('full'), // Spans full width on mobile
            ])
            ->columns([
                'sm' => 1, // Single column layout on small screens
                'lg' => 2, // Two-column layout on larger screens
            ]);
    }



    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->limit(50),
                TextColumn::make('transaction_date')
                    ->label('Date')
                    ->sortable(),
                TextColumn::make('expenses')
                    ->label('Expenses')
                    ->sortable()
                    ->formatStateUsing(fn (string|int|null $state): string => 'Rp ' . number_format((int) $state, 0, ',', '.')),
                TextColumn::make('income')
                    ->label('Income')
                    ->sortable()
                    ->formatStateUsing(fn (string|int|null $state): string => 'Rp ' . number_format((int) $state, 0, ',', '.')),
                TextColumn::make('balance')
                    ->label('Balance')
                    ->sortable()
                    ->formatStateUsing(fn (string|int|null $state): string => 'Rp ' . number_format((int) $state, 0, ',', '.')),
                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(50),
        ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }



    public static function getRelations(): array
    {
        return [
            // Add related models here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashFlows::route('/'),
            'create' => Pages\CreateCashFlow::route('/create'),
            'edit' => Pages\EditCashFlow::route('/{record}/edit'),
        ];
    }
}
