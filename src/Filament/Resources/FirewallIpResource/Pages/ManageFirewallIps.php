<?php

namespace SolutionForest\FilamentFirewall\Filament\Resources\FirewallIpResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Request;
use SolutionForest\FilamentFirewall\Facades\FilamentFirewall;
use SolutionForest\FilamentFirewall\Filament\Resources\FirewallIpResource;

class ManageFirewallIps extends ManageRecords
{
    protected static string $resource = FirewallIpResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('addMyIp')
                ->label(__('filament-firewall::filament-firewall.action.addMyIp'))
                ->action('addMyIp'),
            CreateAction::make()
                ->label(__('filament-actions::create.single.label', ['label' => null])),
        ];
    }

    public function addMyIp()
    {
        try {
            $currIp = Request::getClientIp();

            if (FilamentFirewall::getFirewallIpModel()::query()->where('ip', $currIp)->whereNull('prefix_size')->first()) {
            
                Notification::make()
                    ->title(__('filament-firewall::filament-firewall.action.addMyIp.alreadyAdded'))
                    ->danger()
                    ->send();

                return;
            }

            $data = [
                'ip' => $currIp,
                'blocked' => false,
            ];

            $record = new ($this->getModel())($data);

            if ($tenant = Filament::getTenant()) {
                $record = $this->associateRecordWithTenant($record, $tenant);

            } else {

                $record->save();
            }

            Notification::make()
                ->title(__('filament-actions::create.single.notifications.created.title'))
                ->success()
                ->send();
    
        } catch (\Exception $e) {
            //
        }
    }
}
