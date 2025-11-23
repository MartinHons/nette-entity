<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Entity\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Table
{
    public function __construct(
        public readonly string $tableName
    ) {
    }
}
