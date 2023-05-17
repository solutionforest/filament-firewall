<?php

namespace SolutionForest\FilamentFirewall\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use SolutionForest\FilamentFirewall\Filament\Resources\FirewallIpResource\Pages;

class FirewallIpResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ip')
                    ->label(__('filament-firewall::filament-firewall.form.field.ip'))
                    ->default(fn () => Request::getClientIp())
                    ->regex('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/')
                    ->validationAttribute(Str::upper(__('filament-firewall::filament-firewall.form.field.ip')))
                    ->suffixAction(fn (callable $set) =>
                        Forms\Components\Actions\Action::make('fillMyIp')
                            ->label(__('filament-firewall::filament-firewall.action.fillMyIp'))
                            ->icon('heroicon-o-pencil-alt')
                            ->action(fn () => $set('ip', Request::getClientIp()))
                    )
                    ->required(),
                    
                Forms\Components\TextInput::make('prefix_size')
                    ->label(__('filament-firewall::filament-firewall.form.field.prefix_size'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(32)
                    ->prefix('/'),

                Forms\Components\Radio::make('blocked')
                    ->label(__('filament-firewall::filament-firewall.form.field.is_allow'))
                    ->options([
                        0 => __('filament-firewall::filament-firewall.labels.allow'),
                        1 => __('filament-firewall::filament-firewall.labels.deny'),
                    ])
                    ->default(1),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ip')
                    ->label(__('filament-firewall::filament-firewall.table.column.ip'))
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('prefix_size')
                    ->label(__('filament-firewall::filament-firewall.table.column.prefix_size'))
                    ->formatStateUsing(fn (?string $state): ?string => $state ? str($state)->prepend('/') : null)
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\IconColumn::make('blocked')
                    ->label(__('filament-firewall::filament-firewall.table.column.is_allow'))
                    ->options([
                        'heroicon-o-x-circle' => fn (bool $record) => boolval($record),
                        'heroicon-o-check-circle' => fn (bool $record) => ! boolval($record),
                    ])
                    ->colors([
                        'danger' => fn (bool $record) => boolval($record),
                        'success' => fn (bool $record) => ! boolval($record),
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFirewallIps::route('/'),
        ];
    }

    public static function getModel(): string
    {
        return config('filament-firewall.models.ip', \SolutionForest\FilamentFirewall\Models\Ip::class);
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament-firewall::filament-firewall.filament.resource.ip.navigationLabel');
    }

    public static function getLabel(): string
    {
        return __('filament-firewall::filament-firewall.filament.resource.ip.label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-firewall::filament-firewall.filament.resource.ip.modalLabel');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-firewall::filament-firewall.filament.resource.ip.pluralLabel');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-firewall::filament-firewall.filament.resource.ip.pluralModelLabel');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('filament-firewall::filament-firewall.filament.resource.ip.getNavigationGroup');
    }
}
