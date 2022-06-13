<?php

namespace Turnover\Base\Traits;

use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;

trait HasTransformerTrait {

    private function applyTransform($data, bool $isCollection = true): array|null
    {
        if ( ! $data) {
            return $isCollection ? ['data' => []] : null;
        }

        $response = $isCollection
            ? new Collection($data, $this->transformer)
            : new Item($data, $this->transformer);

        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());

        return $manager->createData($response)->toArray();
    }
}
