<?php

namespace SolutionForest\FilamentFirewall\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                    ->suffixAction(Forms\Components\Actions\Action::make('fillMyIp')
                        ->label(__('filament-firewall::filament-firewall.action.fillMyIp'))
                        ->icon('heroicon-o-pencil')
                        ->action(fn (Set $set) => $set('ip', Request::getClientIp()))
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
                    ->boolean()
                    ->falseIcon('heroicon-o-check-circle')
                    ->falseColor('success')
                    ->trueIcon('heroicon-o-x-circle')
                    ->trueColor('danger'),
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

    public static function getNavigationLabel(): string
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

    public static function getNavigationGroup(): ?string
    {
        return __('filament-firewall::filament-firewall.filament.resource.ip.getNavigationGroup');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
