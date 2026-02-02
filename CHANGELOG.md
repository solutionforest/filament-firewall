# Changelog

All notable changes to `filament-firewall` will be documented in this file.

## 4.0.0 - 2026-02-02

### v4.0.0 Release

This major release upgrades the Filament Firewall Plugin to support Filament v5, bringing enhanced compatibility and new features aligned with the latest Filament framework.

#### What's New

- Full compatibility with Filament v5
- Improved performance and stability
- Updated dependencies to match Filament v5 requirements

#### Breaking Changes

- Minimum required Filament version is now v5.0

#### How to Upgrade

1. Update your `composer.json` to require `"solution-forest/filament-firewall: "^4.0"`
2. Run `composer update`
3. Publish updated assets: `php artisan filament:assets`
4. If using custom themes, update your `tailwind.config.js` with the new asset paths
5. Test your tree widgets/pages for any custom overrides that may need adjustment

For full details, see the [commit changes](https://github.com/solutionforest/filament-firewall/commit/0892d66efb8c356e261231e2607d9ea3b5f5160a). If you encounter issues, please check the [documentation](https://github.com/solutionforest/filament-firewall#readme) or open an issue.

<!-- Release notes generated using configuration in .github/release.yml at 4.x -->
**Full Changelog**: https://github.com/solutionforest/filament-firewall/compare/3.0.2...4.0.0

## 3.0.2 - 2026-02-02

### What's Changed in 3.0.2

#### 📘 Documentation updates

- Add supported Filament versions to README (63fbeca)

#### 🐛 Bug fixes

- Fix indentation in composer.json dependencies (e3a729d)

#### 🔧 Other Changes

- Bump actions/checkout from 4 to 5 (10d5f1b)
- Bump actions/checkout from 4 to 5 (5ddaccb)
- Bump stefanzweifel/git-auto-commit-action from 6 to 7 (fc39779)
- Bump actions/checkout from 5 to 6 (7d11a8e)
- Handle vendor:publish failures in installer (4935226)

### Installation

**Full Changelog**: https://github.com/solutionforest/filament-firewall/compare/3.0.1...3.0.2

## 3.0.1 - 2025-08-13

### What's Changed in 3.0.1

#### 🔧 Other Changes

* chore: change minimum stability from beta to stable in composer.json

### Installation

```bash
composer require solution-forest/filament-firewall:^3.0.1



```
## Release 3.0.0 - 2025-08-01

### Support Filament v4 🚀

### Installation

```bash
composer require solution-forest/tab-layout-plugin:^3.0.0




```
## 2.0.4 - 2025-08-01

### 🐛 Bug Fixes

- `addMyIp` while with tenant
- Adding error message for `addMyIp` action

### What's Changed

#### Other Changes

* Bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/solutionforest/filament-firewall/pull/12

### New Contributors

* @dependabot[bot] made their first contribution in https://github.com/solutionforest/filament-firewall/pull/12

**Full Changelog**: https://github.com/solutionforest/filament-firewall/compare/2.0.3...2.0.4
