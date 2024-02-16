<?php

declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Days85\Tvdb\ApiClientInterface;

class ResourceFactory
{
    private static array $resourcesInstances = [];

    public static function getResourceInstance(ApiClientInterface $parent, string $resourceClassName): mixed
    {
        if (array_key_exists($resourceClassName, self::$resourcesInstances)) {
            return self::$resourcesInstances[$resourceClassName];
        }

        $classImplements = class_implements($resourceClassName);
        if (! in_array(ResourceInterface::class, $classImplements, true)) {
            throw new \InvalidArgumentException('Resource class must implement ResourceInterface');
        }
        $args = [$parent];
        self::$resourcesInstances[$resourceClassName] = new $resourceClassName(...$args);

        return self::$resourcesInstances[$resourceClassName];
    }
}
