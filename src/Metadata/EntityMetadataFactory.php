<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Entity\Metadata;

use MartinHons\NetteEntity\Entity\Entity;
use MartinHons\NetteEntity\Metadata\Reflection\EntityReflection;
use MartinHons\NetteEntity\Metadata\Reflection\RepositoryReflection;
use MartinHons\NetteEntity\Repository\IRepository;

class EntityMetadataFactory
{
    /** @param class-string<IRepository<Entity>> $repositoryClass */
    public function create(string $repositoryClass): EntityMetadata
    {
        $repositoryReflection = new RepositoryReflection($repositoryClass);
        $entityClass = $repositoryReflection->getEntityClass();

        $entityReflection = new EntityReflection($entityClass);
        $tableName = $entityReflection->getTableName();
        $properties = $entityReflection->getProperties();

        return new EntityMetadata($tableName, $entityClass, $properties);
    }
}
