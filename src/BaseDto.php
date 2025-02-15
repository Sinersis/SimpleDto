<?php

namespace SimpleDto;

use ReflectionClass;
use SimpleDto\Attributes\Cast;

abstract class BaseDto
{

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    protected function fill(array $data): void
    {
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName();

            if (!array_key_exists($name, $data)) {
                continue;
            }

            $value = $data[$name];

            $attributes = $property->getAttributes(Cast::class);
            if (!empty($attributes)) {
                /** @var Cast $cast */
                $cast = $attributes[0]->newInstance();

                if ($cast->isArray && is_array($value)) {
                    $value = array_map(function ($item) use ($cast) {
                        return new $cast->class($item);
                    }, $value);
                } elseif (!$cast->isArray && is_array($value)) {
                    $value = new $cast->class($value);
                }

                $property->setValue($this, $value);
                continue;
            }

            $type = $property->getType();
            if ($type && !$type->isBuiltin()) {
                $className = $type->getName();

                if (is_subclass_of($className, BaseDTO::class) && is_array($value)) {
                    $value = new $className($value);
                }
            }

            $property->setValue($this, $value);
        }
    }

}