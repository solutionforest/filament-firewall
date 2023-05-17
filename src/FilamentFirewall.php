<?php

namespace SolutionForest\FilamentFirewall;

use Illuminate\Support\Collection;

class FilamentFirewall
{
    public function getWhiteList(): Collection
    {
        return $this->getFirewallIpModel()::query()->where('blocked', false)->get();
    }

    public function withinWhitelist($ip): bool
    {
        $list = $this->getWhiteList()
            ->map(function ($record) {
                $ip = $record->ip;
                if ($record->prefix_size) {
                    $ip = (string) str($ip)->finish('/')->finish($record->prefix_size);
                }
                return $ip;
            })
            ->toArray();
        return \Symfony\Component\HttpFoundation\IpUtils::checkIp($ip, $list);
    }

    public function getBlackList(): Collection
    {
        return $this->getFirewallIpModel()::blocked()->get();
    }

    public function withinBlackList($ip): bool
    {
        $list = $this->getBlackList()
            ->map(function ($record) {
                $ip = $record->ip;
                if ($record->prefix_size) {
                    $ip = (string) str($ip)->finish('/')->finish($record->prefix_size);
                }
                return $ip;
            })
            ->toArray();
        return \Symfony\Component\HttpFoundation\IpUtils::checkIp($ip, $list);
    }

    public function getFirewallIpModel(): string
    {
        return config('filament-firewall.models.ip', \SolutionForest\FilamentFirewall\Models\Ip::class);
    }
}