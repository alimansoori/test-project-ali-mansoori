<?php
namespace App\Library;


use App\Library\Strategy\StrategyInterface;

class Context
{
    /**
     * @var StrategyInterface The Context maintains a reference to one of the Strategy
     * objects. The Context does not know the concrete class of a strategy. It
     * should work with all strategies via the Strategy interface.
     */
    private $strategy;

    /**
     * Usually, the Context accepts a strategy through the constructor, but also
     * provides a setter to change it at runtime.
     * @param StrategyInterface $strategy
     */
    public function __construct(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Usually, the Context allows replacing a Strategy object at runtime.
     * @param StrategyInterface $strategy
     */
    public function setStrategy(StrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * The Context delegates some work to the Strategy object instead of
     * implementing multiple versions of the algorithm on its own.
     * @param array $flatArray
     * @param null $startFromIdValue
     * @param string $parentIdKey
     * @param string $primaryKey
     * @param string $childrenKey
     * @return array
     */
    public function executeStrategy(array $flatArray = [], $startFromIdValue = null, string $parentIdKey = 'parent_id', $primaryKey = 'id', $childrenKey = 'children'): array
    {
        return $this->strategy->execute($flatArray, $startFromIdValue, $parentIdKey, $primaryKey, $childrenKey);
    }
}
