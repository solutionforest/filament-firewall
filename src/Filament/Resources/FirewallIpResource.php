<?php

namespace SolutionForest\FilamentFirewall\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use SolutionForest\FilamentFirewall\Filament\Resources\FirewallIpResource\Pages\ManageFirewallIps;
use SolutionForest\FilamentFirewall\Models\Ip;

class FirewallIpResource extends Resource
{
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ip')
                    ->label(__('filament-firewall::filament-firewall.form.field.ip'))
                    ->default(fn () => Request::getClientIp())
                    ->regex('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/')
                    ->validationAttribute(Str::upper(__('filament-firewall::filament-firewall.form.field.ip')))
                    ->suffixAction(Action::make('fillMyIp')
                        ->label(__('filament-firewall::filament-firewall.action.fillMyIp'))
                        ->icon('heroicon-o-pencil')
                        ->action(fn (Set $set) => $set('ip', Request::getClientIp()))
                    )
                    ->required(),

                TextInput::make('prefix_size')
                    ->label(__('filament-firewall::filament-firewall.form.field.prefix_size'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(32)
                    ->prefix('/'),

                Radio::make('blocked')
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
                TextColumn::make('ip')
                    ->label(__('filament-firewall::filament-firewall.table.column.ip'))
                    ->searchable(isIndividual: true)
                    ->sortable(),
                TextColumn::make('prefix_size')
                    ->label(__('filament-firewall::filament-firewall.table.column.prefix_size'))
                    ->formatStateUsing(fn (?string $state): ?string => $state ? (string) str($state)->prepend('/') : null)
                    ->searchable(isIndividual: true)
                    ->sortable(),
                IconColumn::make('blocked')
                    ->label(__('filament-firewall::filament-firewall.table.column.is_allow'))
                    ->boolean()
                    ->falseIcon('heroicon-o-check-circle')
                    ->falseColor('success')
                    ->trueIcon('heroicon-o-x-circle')
                    ->trueColor('danger'),
                TextColumn::make('created_at')
                    ->label(__('filament-firewall::filament-firewall.table.column.created_at'))
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('filament-firewall::filament-firewall.table.column.updated_at'))
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFirewallIps::route('/'),
        ];
    }

    public static function getModel(): string
    {
        return config('filament-firewall.models.ip', Ip::class);
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-shield-check';
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
