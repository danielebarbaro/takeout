<?php

namespace App\Services;

use App\Services;

abstract class Category
{
    const CACHE = 'Cache';
    const DATABASE = 'Database';
    const MAIL = 'Mail';
    const SEARCH = 'Search';
    const STORAGE = 'Storage';
    const TOOLS = 'Tools';

    public static function mapByService(): array
    {
        return collect((new Services)->all())
            ->mapWithKeys(function ($fqcn, $shortName) {
                return [$shortName => $fqcn::category()];
            })
            ->toArray();
    }

    public static function fromServiceName(string $serviceName): string
    {
        $serviceMap = self::mapByService();
        return array_key_exists($serviceName, $serviceMap) ?
            strtolower($serviceMap[$serviceName]) :
            'other';
    }

    public static function fromContainerName(string $containerName): string
    {
        $serviceName = array_slice(
            explode('--', $containerName),
            1,
            1
        );
        $serviceName = reset($serviceName);
        return self::fromServiceName($serviceName);
    }
}
