<?php

namespace Commercetools\Training;

use Commercetools\Core\Model\Product\ProductProjectionCollection;

class ProductSearchService extends AbstractService
{
    /**
     * @param $locale
     * @param $searchText
     * @return ProductProjectionCollection
     */
    public function fulltextSearch($locale, $searchText)
    {
        //TODO: 8.1 do a full text search
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param $attributeName
     * @param $attributeValue
     * @return ProductProjectionCollection
     */
    public function facetSearch($attributeName, $attributeValue)
    {
        //TODO: 8.2 search by facets
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
