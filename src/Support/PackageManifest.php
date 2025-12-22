<?php

namespace InterNACHI\Modular\Support;

use Illuminate\Support\Collection;

class PackageManifest extends \Illuminate\Foundation\PackageManifest
{
    public function build(): void
    {
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath.'/composer/installed.json')) {
            $installed = json_decode($this->files->get($path), true);

            $packages = $installed['packages'] ?? $installed;
        }

        app(FinderFactory::class)->moduleComposerFileFinder()->each(function ($file) use (&$packages) {
            $packages[] = json_decode($this->files->get($file->getRealPath()), true);
        });

        $ignoreAll = in_array('*', $ignore = $this->packagesToIgnore());

        $this->write((new Collection($packages))->mapWithKeys(function ($package) {
            return [$this->format($package['name']) => $package['extra']['laravel'] ?? []];
        })->each(function ($configuration) use (&$ignore) {
            $ignore = array_merge($ignore, $configuration['dont-discover'] ?? []);
        })->reject(function ($configuration, $package) use ($ignore, $ignoreAll) {
            return $ignoreAll || in_array($package, $ignore);
        })->filter()->all());

        // Force reload manifest
        $this->manifest = null;
        $this->getManifest();
    }
}
