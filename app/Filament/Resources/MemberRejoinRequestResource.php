<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberRejoinRequestResource\Pages;
use App\Filament\Resources\MemberRejoinRequestResource\RelationManagers;
use App\Models\MemberRejoinRequest;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class MemberRejoinRequestResource extends Resource
{
    protected static ?string $model = MemberRejoinRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationLabel = 'Member Rejoin';
    protected static ?string $navigationGroup = 'Request';
    protected static ?string $slug = 'member-rejoin-request';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("User")
                    ->description('Data Member')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->disabled(),
                        TextInput::make('username')
                            ->label('Username')
                            ->required()
                            ->disabled(),
                        TextInput::make('regional')
                            ->label('Regional')
                            ->required()
                            ->disabled(),
                        TextInput::make('executed_by')
                            ->label('Executed By')
                            ->required()
                            ->disabled(),
                        TextInput::make('rejoin_authorization')
                            ->label('Rejoin Authorization')
                            ->required()
                            ->disabled(),
                        TextInput::make('joined_gathering')
                            ->label('Join Gathering')
                            ->required()
                            ->disabled(),
                        TextInput::make('join_at')
                            ->label('Join Date')
                            ->required()
                            ->disabled(),
                        TextInput::make('leave_at')
                            ->label('Leave Date')
                            ->required()
                            ->disabled(),
                ])->columns(2)
                ->collapsible(),
                Section::make("Activities")->schema([
                    Textarea::make('last_activities')
                        ->label('Last Activities')
                        ->rows(10)
                        ->cols(50)
                        ->columnSpan("full")
                        ->disabled(),
                ]),
                Section::make("Social Links")->schema([
                    TextInput::make('facebook_link')
                        ->label('Facebook Link')
                        ->url()
                        ->required()
                        ->columnSpan(1)
                        ->suffixAction(
                            Action::make('copy')
                                ->icon('heroicon-s-clipboard-document-check')
                                ->action(function ($livewire, $state) {
                                    $livewire->js(
                                        'window.navigator.clipboard.writeText("'.$state.'");
                                        $tooltip("'.__('Copied to clipboard').'", { timeout: 1500 });'
                                    );
                                })
                        )
                        ->disabled(),
                ]),
                Section::make("Attachment")->schema([
                    Placeholder::make('ktp')
                        ->label("KTP")
                        ->content(function ($record): HtmlString {
                            if ($record && $record->ktp) {
                                return new HtmlString("<img src='" . $record->ktp . "' style='width: 100%;'>");
                            } else {
                                return new HtmlString("<span>No KTP uploaded</span>");
                            }
                        }),

                    Placeholder::make('file')
                        ->label("Membership Documents")
                        ->content(function ($record): HtmlString {
                            if ($record && $record->file) {
                                return new HtmlString("<img src='" . $record->file . "' style='width: 100%;'>");
                            } else {
                                return new HtmlString("<span>No file uploaded</span>");
                            }
                        }),
                ])->columns(2)->collapsible(),
                Section::make("Reason")->schema([
                    Textarea::make('reason_leave')
                        ->label('Reason Leave Notes')
                        ->rows(10)
                        ->cols(50)
                        ->columnSpan(1)
                        ->disabled(),
                    Textarea::make('reason_join')
                        ->label('Reason Join Notes')
                        ->rows(10)
                        ->cols(50)
                        ->columnSpan(1)
                        ->disabled(),
                ])->columns(2)->collapsible(),
                Section::make("Notes")->schema([
                    Textarea::make('notes')
                        ->label('Member Notes')
                        ->rows(10)
                        ->cols(50)
                        ->columnSpan(1)
                        ->disabled(),
                    Textarea::make('admin_notes')
                        ->label('Admin Notes')
                        ->rows(10)
                        ->cols(50)
                        ->maxLength(200)
                        ->required()
                        ->columnSpan(1)
                ])->columns(2)->collapsible(),
                Select::make('status')
                    ->label("Status Rejoin")
                    ->required()
                    ->columnSpan("full")
                    ->options([
                        'approved' => 'Approved',
                        'reviewing' => 'Reviewing',
                        'rejected' => 'Rejected',
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
                TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable(),
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable(),
                TextColumn::make('facebook_link')
                    ->label('Facebook')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('executed_by')
                    ->label('Executed By')
                    ->searchable(),
                TextColumn::make('rejoin_authorization')
                    ->label('Rejoin Authorization')
                    ->searchable(),
                TextColumn::make('join_at')
                    ->label('Join Date')
                    ->sortable(),
                TextColumn::make('leave_at')
                    ->label('Leave Date')
                    ->sortable(),
                TextColumn::make('joined_gathering')
                    ->label('Join Gathering')
                    ->formatStateUsing(fn (string $state) => Str::title($state))
                    ->color(fn (string $state): string => match ($state) {
                        'Joined' => 'success',
                        'Not Joined' => 'danger',
                        default => 'info'
                    })
                    ->badge()
                    ->tooltip(fn ($state) => $state ? 'User has joined the gathering' : 'User has not joined the gathering'),
                TextColumn::make('status')
                    ->label('Status Rejoin')
                    ->formatStateUsing(fn (string $state) => Str::title($state)) // Capitalize the first letter
                    ->color(fn (string $state): string => match ($state) {
                        'reviewing' => 'primary',
                        'rejected' => 'danger',
                        'approved' => 'success',
                        default => 'info',
                    })
                    ->badge()

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([]);
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
            'index' => Pages\ListMemberRejoinRequests::route('/'),
            'create' => Pages\CreateMemberRejoinRequest::route('/create'),
            'edit' => Pages\EditMemberRejoinRequest::route('/{record}/edit'),
        ];
    }
}
