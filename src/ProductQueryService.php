<?php

namespace Commercetools\Training;

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
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param Category $category
     * @return ProductProjectionCollection
     */
    public function withCategory(Category $category)
    {
        //TODO: 4.2 query products by a category
        $request = null;

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
        //TODO: 4.3 find products with category name
    }
}
