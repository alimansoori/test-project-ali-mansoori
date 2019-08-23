<?php
namespace App\Library\Strategy;

/**
 * Concrete Strategies implement the algorithm while following the base Strategy
 * interface. The interface makes them interchangeable in the Context.
 */
class FastRecursiveStrategy implements StrategyInterface
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
        $grouped = $this->groupedByParentKey($flatArray, $parentIdKey);

        return $this->treeBuilder($grouped[0], $grouped, $primaryKey, $childrenKey);
    }

    /**
     * @param array $siblings
     * @param array $grouped
     * @param string $primaryKey
     * @param string $childrenKey
     * @return array
     */
    private function treeBuilder(array $siblings, array $grouped, string $primaryKey, string $childrenKey)
    {
        foreach ($siblings as $k => $sibling) {
            $id = $sibling[$primaryKey];
            if(isset($grouped[$id])) {
                $sibling[$childrenKey] = $this->treeBuilder($grouped[$id], $grouped, $primaryKey, $childrenKey);
            }
            $siblings[$k] = $sibling;
        }

        return $siblings;
    }

    /**
     * grouped flatArray By ParentKey
     * @param array $flatArray
     * @param string $parentIdKey
     * @return array
     */
    private function groupedByParentKey(array $flatArray, string $parentIdKey): array
    {
        $grouped = [];
        foreach ($flatArray as $sub){
            $grouped[$this->getNumericParentIdKey($sub, $parentIdKey)][] = $sub;
        }

        return $grouped;
    }

    private function getNumericParentIdKey($sub, $parentIdKey)
    {
        return ($sub[$parentIdKey]) ? $sub[$parentIdKey] : 0;
    }
}
