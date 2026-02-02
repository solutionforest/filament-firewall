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
                        try {
                            $command->call('vendor:publish', [
                                '--tag' => 'firewall',   // Required package
                                ]);
                        } catch (\Throwable $th) {
                            // display error message
                            $installCommand = 'php artisan vendor:publish --tag=firewall';
                            $command->error('Failed to publish Akaunting Firewall resources. Please make sure Akaunting Firewall is installed.');
                            // display instruction to user
                            $command->info("Please run the following command manually: \n  $installCommand");
                            // stop execution
                            exit(1);
                        }
                    })
                    ->endWith(function (InstallCommand $command) {
                        // run migration
                        $command->call('migrate');
                    });
            });
    }
}
