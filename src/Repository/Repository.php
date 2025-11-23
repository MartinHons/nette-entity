<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Repository;

use MartinHons\NetteEntity\Entity\Entity;
use MartinHons\NetteEntity\Metadata\EntityMetadata;
use Nette\Database\Explorer;

/**
 * @template T of Entity
 * @implements IRepository<T>
 */
abstract class Repository implements IRepository
{
    /** @use TEvents<T> */
    use TEvents;

    final public function __construct(
        protected Explorer $db,
        protected ?EntityMetadata $metadata = null
    ) {
    }
}
