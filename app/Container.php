<?php

declare(strict_types=1);

namespace App;

use ReflectionClass;
use Psr\Container\ContainerInterface;
use App\Exceptions\ContainerException;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class Container implements ContainerInterface
{
    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    private function resolve(string $id)
    {
        $reflectionClass = new ReflectionClass($id);

        if ($reflectionClass->isInstantiable() == false) {
            throw new ContainerException("Class {$id} is not instantiable.");
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor == null) {
            return new $id();
        }

        $parameters = $constructor->getParameters();

        if ($parameters == []) {
            return new $id();
        }

        $dependencies = array_map(function (ReflectionParameter $reflectionParameter) use ($id) {
            $name = $reflectionParameter->getName();
            $type = $reflectionParameter->getType();

            if ($type == null) {
                throw new ContainerException("Failed to resolve parameter {$name} in class {$id}.");
            }

            if ($type instanceof ReflectionUnionType) {
                throw new ContainerException("Failed to resolve union type parameter {$name} in class {$id}.");
            }

            if ($type instanceof ReflectionNamedType && $type->isBuiltin() == false) {
                return $this->get($type->getName());
            }

            throw new ContainerException("Failed to resolve invalid parameter {$name} in class {$id}.");
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}
