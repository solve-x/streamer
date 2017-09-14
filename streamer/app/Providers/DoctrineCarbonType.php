<?php

namespace App\Providers;

use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class DoctrineCarbonType extends DateTimeType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $instance = parent::convertToPHPValue($value, $platform);

        if ($instance === null) {
            return $instance;
        }

        return Carbon::instance($instance);
    }
}
