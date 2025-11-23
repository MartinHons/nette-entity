<?php

declare(strict_types=1);

namespace MartinHons\NetteEntity\Metadata\Reflection;

use LogicException;
use MartinHons\NetteEntity\Entity\Entity;
use MartinHons\NetteEntity\Repository\IRepository;
use ReflectionClass;

class RepositoryReflection
{
    /** @var ReflectionClass<IRepository<Entity>> */
    private ReflectionClass $repositoryRef;


    /** @param class-string<IRepository<Entity>> $repositoryClass */
    public function __construct(string $repositoryClass)
    {
        $this->repositoryRef = new ReflectionClass($repositoryClass);
    }


    /** @return class-string<Entity> */
    public function getEntityClass(): string
    {
        $doc = $this->repositoryRef->getDocComment();

        if (is_string($doc) && preg_match('/@extends\s+\S+<([^>]+)>/', $doc, $matches)) {
            $classAlias = trim($matches[1]);
            $class = $this->resolveClass($classAlias, $this->repositoryRef);
            if (class_exists($class) && is_subclass_of($class, Entity::class)) {
                return $class;
            }
            throw new LogicException(sprintf('Class "%s" is not subclass of "%s"', $class, Entity::class));
        }

        throw new LogicException(sprintf('Repository "%s" does not have @extends PHPDoc annotation.', $this->repositoryRef->getName()));
    }


    /** @param ReflectionClass<IRepository<Entity>> $reflection */
    private function resolveClass(string $classAlias, ReflectionClass $reflection): string
    {
        if (str_starts_with($classAlias, '\\')) {
            return ltrim($classAlias, '\\');
        }

        $namespace = $reflection->getNamespaceName();
        $fileName = $reflection->getFileName();

        if ($fileName === false) {
            throw new LogicException('Unable to determine file path for reflection class');
        }

        $fileContent = file_get_contents($fileName);

        if ($fileContent === false) {
            throw new LogicException(sprintf('Unable to read file "%s"', $fileName));
        }

        // Searching for the class between the use directives
        $pattern = '/use\s+([^;]+\\\\' . preg_quote($classAlias, '/') . ')(?:\s+as\s+\w+)?;/';

        if (preg_match($pattern, $fileContent, $matches)) {
            return trim($matches[1]);
        }

        // Class is in the same namespace
        return $namespace . '\\' . $classAlias;
    }
}
