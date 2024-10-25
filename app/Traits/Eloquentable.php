<?php

declare(strict_types=1);

namespace App\Traits;

use ReflectionClass;
use Illuminate\Support\Str;

trait Eloquentable
{
    public function eloquentValues(): array
    {
        // Use reflection to get all public properties and their values
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        $result = [];

        // Iterate over the properties, convert to snake_case, and filter out null values
        foreach ($properties as $property) {
            $value = $property->getValue($this);
            if ($value !== null) {
                $result[Str::snake($property->getName())] = $value;
            }
        }

        return $result;
    }
}
