<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Entity\Metadata;

use MartinHons\NetteEntity\Entity\Entity;

readonly class EntityMetadata
{
    /**
     * @param class-string<Entity> $className
     * @param PropertyMetadata[] $properties
     */
    public function __construct(
        public string $tableName,
        public string $className,
        public array $properties
    ) {
    }
}
