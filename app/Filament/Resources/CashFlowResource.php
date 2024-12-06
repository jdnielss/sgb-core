<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashFlowResource\Pages;
use App\Models\CashFlow;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\{DatePicker, FileUpload, Textarea, TextInput};
use Filament\Tables\Actions\{EditAction, BulkActionGroup, DeleteBulkAction};
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;
use Filament\Tables\Columns\{TextColumn};


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
                    ->placeholder("Nama Transaksi")
                    ->columnSpan(2),

                DatePicker::make('transaction_date')
                    ->label('Transaction Date')
                    ->required()
                    ->placeholder("Tanggal Transaksi")
                    ->columnSpan('full'),

                TextInput::make('expenses')
                    ->label('Expenses')
                    ->prefix("Rp. ")
                    ->minValue(0)
                    ->numeric()
                    ->required()
                    ->placeholder("Pengeluaran")
                    ->columnSpan(1),

                TextInput::make('income')
                    ->label('Income')
                    ->prefix("Rp. ")
                    ->minValue(0)
                    ->numeric()
                    ->required()
                    ->placeholder("Pemasukan")
                    ->columnSpan(1),

                Textarea::make('notes')
                    ->label('Notes')
                    ->maxLength(255)
                    ->rows(10)
                    ->cols(20)
                    ->required()
                    ->placeholder("Pembelian Kertas")
                    ->columnSpan('full'),

                FileUpload::make('attachment')
                    ->label('Attachment')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(1024)
                    ->required()
                    ->columnSpan('full'),

                PdfViewerField::make('attachment')
                    ->label('View the PDF')
                    ->minHeight('100svh')
                    ->columnSpan('full'),
            ])
            ->columns([
                'sm' => 1,
                'lg' => 2,
            ]);
    }



    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No. ')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->label('Name')
                    ->limit(50),
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
                    ->limit(20),
                TextColumn::make('transaction_date')
                    ->label('Transaction Date')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created Date'),
                TextColumn::make('updated_at')
                    ->label('Updated Date')
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
