<?php

namespace InterNACHI\Modular\Tests;

use Composer\Json\JsonFile;
use Illuminate\Encryption\Encrypter;
use InterNACHI\Modular\Console\Commands\Make\MakeModule;
use InterNACHI\Modular\Support\DatabaseFactoryHelper;
use InterNACHI\Modular\Support\Facades\Modules;
use InterNACHI\Modular\Support\ModularizedCommandsServiceProvider;
use InterNACHI\Modular\Support\ModularServiceProvider;
use InterNACHI\Modular\Support\ModuleConfig;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public string $app_composer_file;

    public array $original_app_composer_contents;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app_composer_file = $this->getApplicationBasePath().'/composer.json';

        $json_file = new JsonFile($this->app_composer_file);
        $this->original_app_composer_contents = $json_file->read();

        Modules::reload();

        $config = $this->app['config'];

        // Add encryption key for HTTP tests
        $config->set('app.key', 'base64:'.base64_encode(Encrypter::generateKey('AES-128-CBC')));

        // Add stubs to view
        // $this->app['view']->addLocation(__DIR__.'/Feature/stubs');
    }

    protected function tearDown(): void
    {
        $this->app->make(DatabaseFactoryHelper::class)->resetResolvers();

        $json_file = new JsonFile($this->app_composer_file);
        $json_file->write($this->original_app_composer_contents);

        parent::tearDown();
    }

    protected function makeModule(string $name = 'test-module'): ModuleConfig
    {
        $this->artisan(MakeModule::class, [
            'name' => $name,
            '--accept-default-namespace' => true,
        ]);

        return Modules::module($name);
    }

    protected function requiresLaravelVersion(string $minimum_version, string $operator = '>=')
    {
        if (! version_compare($this->app->version(), $minimum_version, $operator)) {
            $this->markTestSkipped("Only applies to Laravel {$operator} {$minimum_version}.");
        }

        return $this;
    }

    protected function getPackageProviders($app)
    {
        return [
            ModularServiceProvider::class,
            ModularizedCommandsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Modules' => Modules::class,
        ];
    }
}
