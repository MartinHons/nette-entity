<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Metadata\Reflection;

use Exception;
use MartinHons\NetteEntity\Entity\Entity;
use MartinHons\NetteEntity\Entity\Metadata\PropertyMetadata;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionProperty;
use ReflectionUnionType;

class PropertyReflection
{
    /** @var ReflectionClass<Entity> */
    private ReflectionClass $entityReflection;


    /** @param class-string<Entity> $entityClass */
    public function __construct(string $entityClass)
    {
        $this->entityReflection = new ReflectionClass($entityClass);
    }


    /** @return PropertyMetadata[] */
    public function getProperties(): array
    {
        $properties = [];
        foreach ($this->entityReflection->getProperties() as $propertyReflection) {
            $property = $this->getProperty($propertyReflection);
            $properties[$property->name] = $property;
        }
        return $properties;
    }


    public function getProperty(ReflectionProperty $propertyReflection): PropertyMetadata
    {
        $type = $propertyReflection->getType();

        if ($type === null) {
            throw new Exception('Property type must be defined.');
        } elseif ($type instanceof ReflectionUnionType) {
            throw new Exception('Union property type is not allowed.');
        } elseif ($type instanceof ReflectionIntersectionType) {
            throw new Exception('Intersection types are not allowed.');
        }

        $name = $propertyReflection->getName();
        return new PropertyMetadata($name);
    }
}
