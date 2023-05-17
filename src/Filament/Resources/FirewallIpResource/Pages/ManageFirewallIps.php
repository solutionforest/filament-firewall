<?php

namespace SolutionForest\FilamentFirewall\Filament\Resources\FirewallIpResource\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Request;
use SolutionForest\FilamentFirewall\Facades\FilamentFirewall;
use SolutionForest\FilamentFirewall\Filament\Resources\FirewallIpResource;

class ManageFirewallIps extends ManageRecords
{
    protected static string $resource = FirewallIpResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('addMyIp')
                ->label(__('filament-firewall::filament-firewall.action.addMyIp'))
                ->action('addMyIp'),
            Actions\CreateAction::make()
                ->label(__('filament-support::actions/create.single.label', ['label' => null]))
                ->disableCreateAnother(),
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

            $this->handleRecordCreation([
                'ip' => $currIp,
                'blocked' => false,
            ]);
            
            Notification::make()
                ->title($this->getCreatedNotificationMessage())
                ->success()
                ->send();
    
        } catch (\Exception $e) {
            
        }
    }
}
