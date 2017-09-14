<?php

namespace App\Providers;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineEnumType extends Type
{
    /**
     * Type name, e.g. "enum_market".
     *
     * @var string
     */
    private $name;

    /**
     * Fully qualified name of an enumeration class.
     *
     * @var string
     */
    private $enumClass;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return (int) $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public static function registerEnumType($typeName, $enumClass)
    {
        if (self::hasType($typeName)) {
            return;
        }

        self::addType($typeName, static::class);

        /** @var DoctrineEnumType $type */
        $type = self::getType($typeName);
        $type->name = $typeName;
        $type->enumClass = $enumClass;
    }
}
