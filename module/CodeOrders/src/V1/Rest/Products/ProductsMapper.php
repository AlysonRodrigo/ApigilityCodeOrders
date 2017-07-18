<?php
/**
 * Created by PhpStorm.
 * User: alyson
 * Date: 18/07/17
 * Time: 00:40
 */

namespace CodeOrders\V1\Rest\Products;


use Zend\Hydrator\HydratorInterface;

class ProductsMapper extends ProductsEntity implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'id' => $object->id,
            'name' => $object->name,
            'description' => $object->description,
            'price' => $object->price
        ];
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        $object->id = $data['id'];
        $object->name = $data['name'];
        $object->description = $data['description'];
        $object->price = $data['price'];

        return $object;
    }
}