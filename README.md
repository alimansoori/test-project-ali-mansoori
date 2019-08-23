Strategy Pattern for algorithms tree view categories 
=======
A simple library for convert categories to nested view.

Install database
-------
Database export is in schemas directory in `schemas/laravel.sql` file name.

Example
-------
Strategy Pattern is in app/Library directory.
In `app/Library/Strategy` is two algorithm strategy.
```php
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
?>
```

the Endpoint for API call
-------
In the routes folder you can find the api.php file. This will hold all the API endpoints. So I created this code.

```php
Route::get('categories','CategoryController@index');
```


Run test
------
Lets check if it works. We can hit this GET route on browser.

`http://127.0.0.1:8000/api/categories` 

This will print the data from `ilya_categories` table as you formatted tree view
