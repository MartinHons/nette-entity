<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Entity\Metadata;

readonly class PropertyMetadata
{
    public function __construct(
        public string $name,
        // public ?string $columnName TODO column name and property name are different
    ) {
    }
}
