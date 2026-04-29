> [!IMPORTANT]
> Please note that we will only be updating to version 4.x, excluding any bug fixes.

## About Solution Forest

[Solution Forest](https://solutionforest.com) Web development agency based in Hong Kong. We help customers to solve their problems. We Love Open Sources.

We have built a collection of best-in-class products:

- [InspireCMS](https://inspirecms.net): A full-featured Laravel CMS with everything you need out of the box. Build smarter, ship faster with our complete content management solution.
- [Filaletter](https://filaletter.solutionforest.net): Filaletter - Filament Newsletter Plugin
- [Website CMS Management](https://filamentphp.com/plugins/solution-forest-cms-website): A hands-on Filament CMS plugin for those who prefer more manual control over their website content management.

# Filament Firewall

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solution-forest/filament-firewall.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-firewall)
[![Total Downloads](https://img.shields.io/packagist/dt/solution-forest/filament-firewall.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-firewall)

This package provides a whitelist and blacklist feature to restrict access to your Laravel application and Filament admin panel. For additional functionality, please refer to the [Laravel Firewall package](https://github.com/akaunting/laravel-firewall).

![filament-firewall-package-1](https://github.com/solutionforest/filament-firewall/assets/68525320/153b1478-003f-4ef9-bebc-8ed249647e9f)
![filament-firewall-package-2](https://github.com/solutionforest/filament-firewall/assets/68525320/1cde3993-77e1-4e64-8e4c-9727f1a40801)

## Supported Filament versions

| Filament Version | Plugin Version |
| ---------------- | -------------- |
| v2               | 1.x.x          |
| v3               | 2.x.x          |
| v4               | 3.x.x          |
| v5               | 4.x.x          |

## Getting Started

1. Install the package using the `composer require` command:

   ```php
   composer require solution-forest/filament-firewall
   ```

2. To publish the configuration files and migrations files for this plugin, as well as automatically run migration, enter the following command:

   ```php
   php artisan filament-firewall:install
   ```

3. This package comes with `WhitelistRangeMiddleware`. You need to register it in `$middleware`:

   **For Laravel version 11.x and above:**

   ```php
   // in bootstrap/app.php
   ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\SolutionForest\FilamentFirewall\Middleware\WhitelistRangeMiddleware::class);
   })
   ```

   **For Laravel versions below 11.x:**

   ```php
   // in app/Http/Kernel.php
   protected $middleware = [
        ...
        \SolutionForest\FilamentFirewall\Middleware\WhitelistRangeMiddleware::class,
   ];
   ```

4. You can change the setting in the `config/filament-firewall.php` file to skip the middleware `WhitelistRangeMiddleware` check.

5. For additional configuration options, you can refer to the [Laravel Firewall configuration file](https://github.com/akaunting/laravel-firewall/blob/master/src/Config/firewall.php) to customize more firewall settings. Some key configuration options include:
   - `config('firewall.enabled')` - Controls whether the firewall is enabled (default: `true`)
   - `config('firewall.middleware')` - Middleware configuration settings

6. Register the plugin in your Panel provider:

   > **Important: Register the plugin in your Panel provider after version 2.x**

   ```bash
    use SolutionForest\FilamentFirewall\FilamentFirewallPlugin;

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugin(FilamentFirewallPlugin::make());
    }
   ```

## Usage

- On the IP Firewall page, you have the ability to add IPs to either a whitelist or a blocklist. The `WhitelistRangeMiddleware` middleware will automatically handle whitelist IP access. If you need to block a range of IPs while allowing a specific IP, such as blocking _172.19.0.0/24_ except for _172.19.0.1_, you'll need to create a new **Deny** access record and specify the IP and prefix as _'172.19.0.0'_ and _'24'_. Additionally, you'll need to add an **Allow** access record for the specific IP _'172.19.0.1'_.

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
