<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Metadata\Reflection;

use Exception;
use MartinHons\NetteEntity\Entity\Metadata\PropertyMetadata;
use ReflectionIntersectionType;
use ReflectionProperty;
use ReflectionUnionType;

class PropertyReflection
{
    public function __construct(
        private ReflectionProperty $propertyReflection
    ) {
    }


    public function getProperty(): PropertyMetadata
    {
        $type = $this->propertyReflection->getType();

        if ($type === null) {
            throw new Exception('Property type must be defined.');
        } elseif ($type instanceof ReflectionUnionType) {
            throw new Exception('Union property type is not allowed.');
        } elseif ($type instanceof ReflectionIntersectionType) {
            throw new Exception('Intersection types are not allowed.');
        }

        $name = $this->propertyReflection->getName();
        return new PropertyMetadata($name);
    }
}
