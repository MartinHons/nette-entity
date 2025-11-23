<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Metadata\Reflection;

use Exception;
use MartinHons\NetteEntity\Entity\Entity;
use MartinHons\NetteEntity\Entity\Mapping\Table;
use ReflectionAttribute;
use ReflectionClass;

class EntityReflection
{
    /** @var ReflectionClass<Entity> */
    private ReflectionClass $entityReflection;


    /** @param class-string<Entity> $entityClass */
    public function __construct(string $entityClass)
    {
        $this->entityReflection = new ReflectionClass($entityClass);
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
}
