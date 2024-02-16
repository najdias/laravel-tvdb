<?php

declare(strict_types=1);

namespace Days85\Tvdb;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DataParser
{
    private static ?Serializer $serializer = null;

    public static function parseData(array $json, string $returnClass)
    {
        return static::getSerializer()->denormalize($json, $returnClass);
    }

    public static function parseDataArray($json, string $returnClass): array
    {
        $result = [];
        if (is_array($json)) {
            foreach ($json as $entry) {
                $result[] = static::parseData($entry, $returnClass);
            }
        }

        return $result;
    }

    private static function getSerializer(): Serializer
    {
        if (static::$serializer === null) {
            $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
            static::$serializer = new Serializer(
                [new ArrayDenormalizer(), new DateTimeNormalizer(), new ObjectNormalizer(null, null, null, $extractor)],
                [new JsonEncoder()]
            );
        }

        return static::$serializer;
    }
}
