<?php

namespace SolutionForest\FilamentFirewall;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Panel;

class FilamentFirewallPlugin implements Plugin
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

    /**
     * @return ?Plugin
     */
    public static function get()
    {
        return Filament::getPlugin(app(static::class)->getId()); // return filament(app(static::class)->getId());
    }
}
