<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Core\Model\Product\Search\Facet;
use Commercetools\Core\Model\Product\Search\Filter;

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
        $request = RequestBuilder::of()->productProjections()->search()->addParam('text.'.$locale, $searchText);

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
        $filterName = 'variants.attributes.' . $attributeName;
        $request = RequestBuilder::of()->productProjections()->search()
            ->addFacet(Facet::ofName($filterName))
            ->addFilter(Filter::ofName($filterName)->setValue($attributeValue))
            ->addFilterFacets(Filter::ofName($filterName)->setValue($attributeValue));

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
