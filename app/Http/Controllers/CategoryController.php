<?php

namespace App\Http\Controllers;

use App\Category;
use App\Library\Context;
use App\Library\Strategy\FastRecursiveStrategy;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();

        $categoriesToArray = CategoryResource::collection($categories)->toArray($this);

        $this->treeViewByStrategyPattern($categoriesToArray);

        return $this->treeViewByStrategyPattern($categoriesToArray);
    }

    private function treeViewByStrategyPattern($categoriesToArray)
    {
        $context = new Context(new FastRecursiveStrategy());

/*      Use another strategy in client
        $context = new Context(new RecursiveStrategy());
*/

        $output = $context->executeStrategy(
            $categoriesToArray,
            null,
            'parent_id',
            'id',
            'child'
        );

        return $output;
    }
}
