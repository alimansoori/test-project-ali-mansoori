<?php
namespace App\Library\Strategy;


interface StrategyInterface
{
    public function execute($flatArray = [], $startFromIdValue = null, $parentIdKey = 'parent_id', $primaryKey = 'id', $childrenKey = 'children'): array ;
}
