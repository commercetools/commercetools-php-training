<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Model\Category\Category;
use Commercetools\Core\Model\Product\ProductProjectionCollection;

class ProductQueryService extends AbstractService
{
    /**
     * @param string $locale
     * @param string $categoryName
     * @return Category
     */
    public function findCategory($locale, $name)
    {
        //TODO: 4.1 find a category
        $request = RequestBuilder::of()->categories()->query()->where("name($locale = \"$name\")");

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response)->current();
    }

    /**
     * @param Category $category
     * @return ProductProjectionCollection
     */
    public function withCategory(Category $category)
    {
        //TODO: 4.2 query products by a category
        $id = $category->getId();
        $request = RequestBuilder::of()->productProjections()->query()->where("categories(id in (\"$id\"))");

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param string $locale
     * @param string $categoryName
     * @return ProductProjectionCollection
     */
    public function findProductsWithCategory($locale, $name)
    {
        return $this->withCategory($this->findCategory($locale, $name));
        //TODO: 4.3 find products with category name
    }
}
