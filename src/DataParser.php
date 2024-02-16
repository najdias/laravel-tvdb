<?php
declare(strict_types = 1);

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

    public static function parseData(array $jsonData, string $className)
    {
        return self::getSerializer()->denormalize($jsonData, $className);
    }

    public static function parseDataArray(array $jsonData, string $className): array
    {
        $parsedData = [];

        if (!empty($jsonData)) {
            foreach ($jsonData as $entry) {
                $parsedData[] = static::parseData($entry, $className);
            }
        }

        return $parsedData;
    }

    private static function getSerializer(): Serializer
    {
        if (self::$serializer === null) {
            $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
            self::$serializer = new Serializer(
                [new ArrayDenormalizer(), new DateTimeNormalizer(), new ObjectNormalizer(null, null, null, $extractor)],
                [new JsonEncoder()]
            );
        }

        return self::$serializer;
    }
}
