<?php
namespace App\Library\Strategy;

/**
 * Concrete Strategies implement the algorithm while following the base Strategy
 * interface. The interface makes them interchangeable in the Context.
 */
class RecursiveStrategy implements StrategyInterface
{

    /**
     * @param array $flatArray
     * @param null $startFromIdValue
     * @param string $parentIdKey
     * @param string $primaryKey
     * @param string $childrenKey
     * @return array
     */
    public function execute($flatArray = [], $startFromIdValue = null, $parentIdKey = 'parent_id', $primaryKey = 'id', $childrenKey = 'children'): array
    {
        $recursiveArray = [];
        $value[$childrenKey] = [];
        foreach ($flatArray as $value) {
            if ($value[$parentIdKey] == $startFromIdValue) {

                $value[$childrenKey] = $this->execute($flatArray, $value[$primaryKey], $parentIdKey, $primaryKey);

                $recursiveArray[] = $value;
            }
        }

        return $recursiveArray;
    }
}
