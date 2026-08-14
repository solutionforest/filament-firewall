<?php

use Illuminate\Support\Collection;
use SolutionForest\FilamentFirewall\FilamentFirewall;

it('matches any ipv4 in whitelist when prefix size is zero', function () {
    $firewall = new class extends FilamentFirewall
    {
        public function getWhiteList(): Collection
        {
            return collect([
                (object) [
                    'ip' => '0.0.0.0',
                    'prefix_size' => 0,
                ],
            ]);
        }
    };

    expect($firewall->withinWhitelist('203.0.113.42'))->toBeTrue();
});

it('matches any ipv4 in blacklist when prefix size is zero', function () {
    $firewall = new class extends FilamentFirewall
    {
        public function getBlackList(): Collection
        {
            return collect([
                (object) [
                    'ip' => '0.0.0.0',
                    'prefix_size' => 0,
                ],
            ]);
        }
    };

    expect($firewall->withinBlackList('198.51.100.8'))->toBeTrue();
});
