<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\DI;

use MartinHons\NetteEntity\Entity\Entity;
use MartinHons\NetteEntity\Entity\EntityMetadataFactory;
use MartinHons\NetteEntity\Repository\IRepository;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Throwable;

class EntityExtension extends CompilerExtension
{
    public function getConfigSchema(): Schema
    {
        return Expect::structure([]);
    }


    public function beforeCompile(): void
    {
        $builder = $this->getContainerBuilder();

        foreach ($builder->getDefinitions() as $definition) {
            $className = $definition->getType();

            if ($className === null || !$definition instanceof ServiceDefinition) {
                continue;
            }

            $implementedInterfaces = class_implements($className);
            if (is_array($implementedInterfaces)) {
                if (in_array(IRepository::class, $implementedInterfaces, true)) {

                    /** @var class-string<IRepository<Entity>> $repositoryClass */
                    $repositoryClass = $className;

                    try {
                        $metadata = (new EntityMetadataFactory)->create($repositoryClass);
                        $definition->setArgument('metadata', $metadata);
                    } catch (Throwable $e) {
                        trigger_error($e->getMessage(), E_USER_WARNING);
                    }
                }
            }
        }
    }
}
