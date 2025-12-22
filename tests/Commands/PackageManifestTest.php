<?php

namespace Commands;

use Illuminate\Foundation\PackageManifest;
use InterNACHI\Modular\Tests\TestCase;

class PackageManifestTest extends TestCase
{
    public function test_it_overrides_package_manifest_providers_discovery(): void
    {
        $this->makeModule('test-module-1');
        $this->makeModule('test-module-2');

        $this->app->make(PackageManifest::class)->build();

        $discoveredProviders = $this->app->make(PackageManifest::class)->providers();

        self::assertContains('Modules\TestModule1\Providers\TestModule1ServiceProvider', $discoveredProviders);
        self::assertContains('Modules\TestModule2\Providers\TestModule2ServiceProvider', $discoveredProviders);
    }
}
