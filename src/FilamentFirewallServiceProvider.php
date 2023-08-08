<?php

namespace SolutionForest\FilamentFirewall;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFirewallServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-firewall';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasConfigFile()
            ->hasMigrations([
                'update_firewall_ips_table',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->startWith(function (InstallCommand $command) {
                        $command->call('vendor:publish', [
                            '--tag' => 'firewall'   // Required package
                        ]);
                    })
                    ->endWith(function (InstallCommand $command) {
                        // run migration
                        $command->call('migrate');
                    });
            });
    }
}
