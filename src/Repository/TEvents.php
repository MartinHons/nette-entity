<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Repository;

use MartinHons\NetteEntity\Entity\Entity;

/** @template T of Entity */
trait TEvents
{
    /** @param T $entity */
    protected function beforeInsert(Entity $entity): void
    {
    }


    /** @param T $entity */
    protected function afterInsert(Entity $entity): void
    {
    }


    /** @param T $entity */
    protected function beforeUpdate(Entity $entity): void
    {
    }


    /** @param T $entity */
    protected function afterUpdate(Entity $entity): void
    {
    }


    /** @param T $entity */
    protected function beforeDelete(Entity $entity): void
    {
    }


    /** @param T $entity */
    protected function afterDelete(Entity $entity): void
    {
    }
}
