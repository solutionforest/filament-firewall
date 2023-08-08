<?php

namespace SolutionForest\FilamentFirewall;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentFirewallPanel implements Plugin
{
    public function getId(): string
    {
        return 'filament-firewall-plugin';
    }

    public function register(Panel $panel): void
    {
        $resources = config('filament-firewall.resources', []);
        $panel->resources($resources);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
    
    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }
}
