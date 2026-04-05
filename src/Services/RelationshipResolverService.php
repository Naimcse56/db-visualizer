<?php

namespace Naimul\DbVisualizer\Services;

use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

class RelationshipResolverService
{
    public function resolve($model): array
    {
        $relations = [];

        $reflection = new ReflectionClass($model);

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

            if ($method->class !== get_class($model)) continue;
            if ($method->getNumberOfParameters() > 0) continue;
            if (str_starts_with($method->getName(), '__')) continue;

            try {

                $result = $this->safeInvoke($model, $method);

                if ($result instanceof Relation) {

                    $relations[] = [
                        'method' => $method->getName(),
                        'type' => class_basename($result),
                        'related' => class_basename(get_class($result->getRelated())),
                    ];
                }

            } catch (\Throwable $e) {
                continue;
            }
        }

        return $relations;
    }

    /**
     * 🔥 SAFE EXECUTION (NO SIDE EFFECT RISK)
     */
    protected function safeInvoke($model, ReflectionMethod $method)
    {
        $instance = clone $model;

        // prevent loaded relations reuse
        if (method_exists($instance, 'unsetRelations')) {
            $instance->unsetRelations();
        }

        return $method->invoke($instance);
    }
}