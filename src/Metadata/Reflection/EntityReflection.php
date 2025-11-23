<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Metadata\Reflection;

use Exception;
use MartinHons\NetteEntity\Entity\Entity;
use MartinHons\NetteEntity\Entity\Mapping\Table;
use MartinHons\NetteEntity\Entity\Metadata\PropertyMetadata;
use ReflectionAttribute;
use ReflectionClass;

class EntityReflection
{
    /** @var ReflectionClass<Entity> */
    private ReflectionClass $entityReflection;


    /** @param class-string<Entity> $repositoryClass */
    public function __construct(
        string $repositoryClass
    ) {
        $this->entityReflection = new ReflectionClass($repositoryClass);
    }


    public function getTableName(): string
    {
        $tableAttributes = $this->entityReflection->getAttributes(
            Table::class,
            ReflectionAttribute::IS_INSTANCEOF
        );
        $attrCount = count($tableAttributes);
        if ($attrCount !== 1) {
            throw new Exception(
                sprintf(
                    'Entity class must have exactly one table atributte. %d attribute/s given.',
                    $attrCount
                )
            );
        }

        $tableName = $tableAttributes[0]->getArguments()[0];
        if (!is_string($tableName)) {
            throw new Exception('The table name must be a string.');
        }

        return $tableName;
    }


    /** @return PropertyMetadata[] */
    public function getProperties(): array
    {
        $properties = [];
        foreach ($this->entityReflection->getProperties() as $propertyReflection) {
            $propertyReflection = new PropertyReflection($propertyReflection);
            $property = $propertyReflection->getProperty();
            $properties[$property->name] = $property;
        }
        return $properties;
    }
}
