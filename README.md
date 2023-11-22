> [!IMPORTANT]
> Please note that we will only be updating to version 2.x, excluding any bug fixes.

# BlackFriday Promotion

![20%_off_Black_friday_promote](https://github.com/solutionforest/Filament-SimpleLightBox/assets/68211972/a724e1eb-d033-490f-823b-3e3155d3b4b3)



- A Event Photo Management Tools [GatherPro.events](https://gatherpro.events/)
  
Promote Code : SFBLACKFRIDAY2023

- [Filament CMS Plugin ](https://filamentphp.com/plugins/solution-forest-cms-website)

Promote Code : SFBLACKFRIDAY2023

# Filament Firewall

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solution-forest/filament-firewall.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-firewall)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/solution-forest/filament-firewall/run-tests?label=tests)](https://github.com/solution-forest/filament-firewall/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/solution-forest/filament-firewall/Check%20&%20fix%20styling?label=code%20style)](https://github.com/solution-forest/filament-firewall/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solution-forest/filament-firewall.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-firewall)

This package provides a whitelist and blacklist feature to restrict access to your Laravel application and Filament admin panel. For additional functionality, please refer to the [Laravel Firewall package](https://github.com/akaunting/laravel-firewall).

![filament-firewall-package-1](https://github.com/solutionforest/filament-firewall/assets/68525320/153b1478-003f-4ef9-bebc-8ed249647e9f)
![filament-firewall-package-2](https://github.com/solutionforest/filament-firewall/assets/68525320/1cde3993-77e1-4e64-8e4c-9727f1a40801)


## Getting Started

1. Install the package using the `composer require` command:

    ```php
    composer require solution-forest/filament-firewall
    ```
2. To publish the configuration files and migrations files for this plugin, as well as automatically run migration, enter the following command:

    ```php
    php artisan filament-firewall:install
    ```
3. This package comes with `WhitelistRangeMiddleware`. You need to register it in `$middleware` in the `app\Http\Kernel.php` file:

    ```bash
    protected $middleware = [
        ...
        \SolutionForest\FilamentFirewall\Middleware\WhitelistRangeMiddleware::class,
    ];
    ```
4. You can change the setting in the `config/filament-firewall.php` file to skip the middleware `WhitelistRangeMiddleware` check.
5. Register the plugin in your Panel provider:
   > **Important:  Register the plugin in your Panel provider after version 2.x**
   ``` bash
    use SolutionForest\FilamentFirewall\FilamentFirewallPanel;
 
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugin(FilamentFirewallPanel::make());
    }
   ```

## Usage
- On the IP Firewall page, you have the ability to add IPs to either a whitelist or a blocklist. The `WhitelistRangeMiddleware` middleware will automatically handle whitelist IP access. If you need to block a range of IPs while allowing a specific IP, such as blocking *172.19.0.0/24* except for *172.19.0.1*, you'll need to create a new **Deny** access record and specify the IP and prefix as *'172.19.0.0'* and *'24'*. Additionally, you'll need to add an **Allow** access record for the specific IP *'172.19.0.1'*.
    
![filament-firewall-package-2](https://github.com/solutionforest/filament-firewall/assets/68525320/1cde3993-77e1-4e64-8e4c-9727f1a40801)
    
- Get whitelist / blacklist records

    ```php
    // whitelist
    \SolutionForest\FilamentFirewall\Facade\FilamentFirewall::getWhiteList();

    // blacklist
    \SolutionForest\FilamentFirewall\Facade\FilamentFirewall::getBlackList();
    ```

- Determine whether an IP address is included in a whitelist or blacklist

    ```php
    // whitelist
    \SolutionForest\FilamentFirewall\Facade\FilamentFirewall::withinWhiteList($ip);
    
    // blacklist
    \SolutionForest\FilamentFirewall\Facade\FilamentFirewall::withinBlackList($ip);
    ```

## Publishing translations
```bash
php artisan vendor:publish --tag=filament-firewall-translations
```

## Security Vulnerabilities
If you discover any security related issues, please email info+package@solutionforest.net instead of using the issue tracker.


## License
Please see [License File](LICENSE.md) for more information.


## Credits
- [Laravel Firewall](https://github.com/akaunting/laravel-firewall)
