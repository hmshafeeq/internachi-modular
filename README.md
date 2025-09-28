<img alt="Modular" src="art/modular.png" width="100%" />

# `hmshafeeq/internachi-modular`

## Credits

**Major credits to:**
- [InterNACHI/modular](https://github.com/InterNACHI/modular) - Original package by InterNACHI
- [MyANApro/modular](https://github.com/MyANApro/modular) - Enhanced fork

This package extends the original `InterNACHI/modular` with additional features and improvements, including enhanced support for `wikimedia/composer-merge-plugin` for better module autoloading.


## Quick Setup for Development

If you're setting up this package for development with symlinked installation:

### 1. Allow Composer Merge Plugin
```shell script
composer config allow-plugins.wikimedia/composer-merge-plugin true
```

### 2. Install Development Version

**Option A: From Packagist (if published)**
```shell script
composer require hmshafeeq/internachi-modular:@dev --no-interaction
```

**Option B: Directly from GitHub**
Add the repository to your `composer.json` and install:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/hmshafeeq/internachi-modular.git"
        }
    ]
}
```

Then install:
```shell script
composer require hmshafeeq/internachi-modular:dev-main --no-interaction
```

**Option C: For Local Development (Symlinked)**
If you have the package in your `packages/` directory:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "packages/internachi-modular",
            "options": {
                "symlink": true
            }
        }
    ]
}
```

Then install:
```shell script
composer require hmshafeeq/internachi-modular:@dev --no-interaction
```

### 3. Enable Automatic Module Discovery (Optional)
Add this to your main `composer.json` if not automatically added:

```json
{
    "extra": {
        "merge-plugin": {
            "include": [
                "app-modules/*/composer.json"
            ]
        }
    }
}
```

This enables automatic discovery and autoloading of modules using the wikimedia/composer-merge-plugin, eliminating the need for manual composer.json updates when creating new modules.

### 4. Clear Caches and Update Autoloader
```shell script
php artisan clear
composer dump-autoload
```

## Enhanced vs Original Approach

This package offers two approaches for module autoloading. Choose the one that best fits your workflow:

### 🚀 Enhanced Approach (Recommended)

**Key Advantages:**
1. **Zero Manual Configuration**: No need to manually update main composer.json for new modules after initial setup
2. **⚡ Instant Availability**: Modules are immediately available after creation
3. **🧹 Cleaner Main composer.json**: Keeps main file focused on actual dependencies
4. **🔄 Simplified Workflow**: One command creates a fully functional module
5. **📦 Better Separation**: Module dependencies are self-contained

**Setup Requirements:**
```bash
# Enable the merge plugin
composer config allow-plugins.wikimedia/composer-merge-plugin true
```

**Main composer.json configuration:**
```json
{
    "extra": {
        "merge-plugin": {
            "include": [
                "app-modules/*/composer.json"
            ]
        }
    }
}
```

**Example: Creating a new module**
```bash
php artisan make:module example
```

That's it! The module is immediately available with zero additional steps.

### 📁 Original InterNACHI Approach

**Setup Requirements:**

**Main composer.json configuration:**
```json
{
    "repositories" : [
        {
            "type" : "path",
            "url" : "app-modules/*",
            "options" : {
                "symlink" : true
            }
        }
    ]
}
```

**Example: Creating a new module**
```bash
# 1. Create the module
php artisan make:module example

# 2. Manually add to composer.json require section if not added by the command
#    "require" : 
#        {
#             ....
#            "modules/example" : "*"
#        }


# 3. Update composer
composer update modules/example
```

### Quick Comparison

| Feature | Enhanced Approach | Original Approach                                                                               |
|---------|------------------|-------------------------------------------------------------------------------------------------|
| **Initial Setup** | Add merge-plugin config once | Add repositories config once                                                                    |
| **New Module Creation** | `php artisan make:module name` | `php artisan make:module name` +  composer.json registration for the module + `composer update` |
| **composer.json Changes** | None after setup | Need to register each module we want to keep in composer.json                           |
| **Autoloading** | Automatic via merge-plugin | Manual registration required                                                                    |

### Which Approach Should You Use?

- **Choose Enhanced Approach** if you create modules frequently and want minimal friction
- **Choose Original Approach** if you prefer explicit control over dependencies or have specific composer workflow requirements

Both approaches are fully supported and you can switch between them at any time.


---

# `internachi/modular`

<div>
	<a href="https://github.com/InterNACHI/modular/actions/workflows/phpunit.yml" target="_blank">
		<img 
			src="https://github.com/InterNACHI/modular/actions/workflows/phpunit.yml/badge.svg" 
			alt="Build Status" 
		/>
	</a>
	<a href="https://codeclimate.com/github/InterNACHI/modular/test_coverage" target="_blank">
		<img 
			src="https://api.codeclimate.com/v1/badges/dd927802d52f4f75ea6c/test_coverage" 
			alt="Coverage Status" 
		/>
	</a>
	<a href="https://packagist.org/packages/internachi/modular" target="_blank">
        <img 
            src="https://poser.pugx.org/internachi/modular/v/stable" 
            alt="Latest Stable Release" 
        />
	</a>
	<a href="./LICENSE" target="_blank">
        <img 
            src="https://poser.pugx.org/internachi/modular/license" 
            alt="MIT Licensed" 
        />
    </a>
    <a href="https://twitter.com/inxilpro" target="_blank">
        <img 
            src="https://img.shields.io/twitter/follow/inxilpro?style=social" 
            alt="Follow @inxilpro on Twitter" 
        />
    </a>
    <a href="https://any.dev/@chris" target="_blank">
        <img 
            src="https://img.shields.io/mastodon/follow/109584001693739813?domain=https%3A%2F%2Fany.dev&style=social" 
            alt="Follow @chris@any.dev on Mastodon" 
        />
    </a>
</div>

`internachi/modular` is a module system for Laravel applications. It uses
[Composer path repositories](https://getcomposer.org/doc/05-repositories.md#path) for autoloading, 
and [Laravel package discovery](https://laravel.com/docs/11.x/packages#package-discovery) for module
initialization, and then provides minimal tooling to fill in any gaps.

This project is as much a set of conventions as it is a package. The fundamental idea
is that you can create “modules” in a separate `app-modules/` directory, which allows you to
better organize large projects. These modules use the existing 
[Laravel package system](https://laravel.com/docs/11.x/packages), and follow existing Laravel
conventions.

- [Walkthrough Video](#walkthrough-video)
- [Installation](#installation)
- [Usage](#usage)
- [Comparison to `nwidart/laravel-modules`](#comparison-to-nwidartlaravel-modules)

## Walkthrough Video

[![Intro video](https://embed-ssl.wistia.com/deliveries/98ebc7e01537a644df2d3af93d928257.jpg?image_crop_resized=1600x900&image_play_button=true&image_play_button_size=2x&image_play_button_color=1e71e7e0)](https://internachi.wistia.com/medias/pivaxithl7?wvideo=pivaxithl7)

## Installation

To get started, run:

```shell script
composer require internachi/modular
```

Laravel will auto-discover the package and everything will be automatically set up for you.

### Publish the config

While not required, it's highly recommended that you customize your default namespace
for modules. By default, this is set to `Modules\`, which works just fine but makes it
harder to extract your module to a separate package should you ever choose to.

We recommend configuring a organization namespace (we use `"InterNACHI"`, for example).
To do this, you'll need to publish the package config:

```shell script
php artisan vendor:publish --tag=modular-config
```

### Create a module

Next, let's create a module:

```shell script
php artisan make:module my-module
```

Modular will scaffold up a new module for you:

```
app-modules/
  my-module/
    composer.json
    src/
    tests/
    routes/
    resources/
    database/
```

It will also add two new entries to your app's `composer.json` file. The first entry registers
`./app-modules/my-module/` as a [path repository](https://getcomposer.org/doc/05-repositories.md#path),
and the second requires `modules/my-module:*` (like any other Composer dependency).

Modular will then remind you to perform a Composer update, so let's do that now:

```shell script
composer update modules/my-module
```

### Optional: Config synchronization

You can run the sync command to make sure that your project is set up
for module support:

```shell script
php artisan modules:sync
```

This will add a `Modules` test suite to your `phpunit.xml` file (if one exists)
and update your [PhpStorm Laravel plugin](https://plugins.jetbrains.com/plugin/7532-laravel)
configuration (if it exists) to properly find your module's views.

It is safe to run this command at any time, as it will only add missing configurations.
You may even want to add it to your `post-autoload-dump` scripts in your application's
`composer.json` file.

## Usage

All modules follow existing Laravel conventions, and auto-discovery 
should work as expected in most cases:

- Commands are auto-registered with Artisan
- Migrations will be run by the Migrator
- Factories are auto-loaded for `factory()`
- Policies are auto-discovered for your Models
- Blade components will be auto-discovered
- Event listeners will be auto-discovered

### Commands

#### Package Commands

We provide a few helper commands:

- `php artisan make:module`  — scaffold a new module
- `php artisan modules:cache` — cache the loaded modules for slightly faster auto-discovery
- `php artisan modules:clear` — clear the module cache
- `php artisan modules:sync`  — update project configs (like `phpunit.xml`) with module settings
- `php artisan modules:list`  — list all modules

#### Laravel “`make:`” Commands

We also add a `--module=` option to most Laravel `make:` commands so that you can
use all the existing tooling that you know. The commands themselves are exactly the
same, which means you can use your [custom stubs](https://laravel.com/docs/11.x/artisan#stub-customization)
and everything else Laravel provides:

- `php artisan make:cast MyModuleCast --module=[module name]`
- `php artisan make:controller MyModuleController --module=[module name]`
- `php artisan make:command MyModuleCommand --module=[module name]`
- `php artisan make:component MyModuleComponent --module=[module name]`
- `php artisan make:channel MyModuleChannel --module=[module name]`
- `php artisan make:event MyModuleEvent --module=[module name]`
- `php artisan make:exception MyModuleException --module=[module name]`
- `php artisan make:factory MyModuleFactory --module=[module name]`
- `php artisan make:job MyModuleJob --module=[module name]`
- `php artisan make:listener MyModuleListener --module=[module name]`
- `php artisan make:mail MyModuleMail --module=[module name]`
- `php artisan make:middleware MyModuleMiddleware --module=[module name]`
- `php artisan make:model MyModule --module=[module name]`
- `php artisan make:notification MyModuleNotification --module=[module name]`
- `php artisan make:observer MyModuleObserver --module=[module name]`
- `php artisan make:policy MyModulePolicy --module=[module name]`
- `php artisan make:provider MyModuleProvider --module=[module name]`
- `php artisan make:request MyModuleRequest --module=[module name]`
- `php artisan make:resource MyModule --module=[module name]`
- `php artisan make:rule MyModuleRule --module=[module name]`
- `php artisan make:seeder MyModuleSeeder --module=[module name]`
- `php artisan make:test MyModuleTest --module=[module name]`

#### Other Laravel Commands

In addition to adding a `--module` option to most `make:` commands, we’ve also added the same
option to the `db:seed` command. If you pass the `--module` option to `db:seed`, it will look
for your seeder within your module namespace:

- `php artisan db:seed --module=[module name]` will try to call `Modules\MyModule\Database\Seeders\DatabaseSeeder`
- `php artisan db:seed --class=MySeeder --module=[module name]` will try to call `Modules\MyModule\Database\Seeders\MySeeder`

#### Vendor Commands

We can also add the `--module` option to commands in 3rd-party packages. The first package
that we support is Livewire. If you have Livewire installed, you can run:

- `php artisan make:livewire counter --module=[module name]`

### Blade Components

Your [Laravel Blade components](https://laravel.com/docs/blade#components) will be
automatically registered for you under a [component namespace](https://laravel.com/docs/9.x/blade#manually-registering-package-components).
A few examples:

| File                                                               | Component                      |
|--------------------------------------------------------------------|--------------------------------|
| `app-modules/demo/src/View/Components/Basic.php`                   | `<x-demo::basic />`            |
| `app-modules/demo/src/View/Components/Nested/One.php`              | `<x-demo::nested.one />`       |
| `app-modules/demo/src/View/Components/Nested/Two.php`              | `<x-demo::nested.two />`       |
| `app-modules/demo/resources/components/anonymous.blade.php`        | `<x-demo::anonymous />`        |
| `app-modules/demo/resources/components/anonymous/index.blade.php`  | `<x-demo::anonymous />`        |
| `app-modules/demo/resources/components/anonymous/nested.blade.php` | `<x-demo::anonymous.nested />` |

### Translations

Your [Laravel Translations](https://laravel.com/docs/11.x/localization#defining-translation-strings) will also
be automatically registered under a component namespace for you. For example, if you have a translation file
at:

`app-modules/demo/resources/lang/en/messages.php`

You could access those translations with: `__('demo::messages.welcome');`

### Customizing the Default Module Structure

When you call `make:module`, Modular will scaffold some basic boilerplate for you. If you 
would like to customize this behavior, you can do so by publishing the `app-modules.php`
config file and adding your own stubs.

Both filenames and file contents support a number of placeholders. These include:

 - `StubBasePath`
 - `StubModuleNamespace`
 - `StubComposerNamespace`
 - `StubModuleNameSingular`
 - `StubModuleNamePlural`
 - `StubModuleName`
 - `StubClassNamePrefix`
 - `StubComposerName`
 - `StubMigrationPrefix`
 - `StubFullyQualifiedTestCaseBase`
 - `StubTestCaseBase`

## Comparison to `nwidart/laravel-modules`

[Laravel Modules](https://nwidart.com/laravel-modules) is a great package that’s been
around since 2016 and is used by 1000's of projects. The main reason we decided to build
our own module system rather than using `laravel-modules` comes down to two decisions:

1. We wanted something that followed Laravel conventions rather than using its own
   directory structure/etc.
2. We wanted something that felt “lighter weight”

If you are building a CMS that needs to support 3rd-party modules that can be dynamically
enabled and disabled, Laravel Modules will be a better fit.

On the other hand, if you're mostly interested in modules for organization, and want to
stick closely to Laravel conventions, we’d highly recommend giving InterNACHI/Modular a try!
