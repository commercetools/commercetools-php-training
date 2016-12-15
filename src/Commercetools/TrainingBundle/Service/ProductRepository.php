<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Core\Model\Product\Search\Facet;
use Commercetools\Core\Model\Product\Search\Filter;
use Commercetools\Core\Request\Products\ProductProjectionByIdGetRequest;
use Commercetools\Core\Request\Products\ProductProjectionQueryRequest;
use Commercetools\Core\Request\Products\ProductProjectionSearchRequest;
use Commercetools\Core\Response\PagedSearchResponse;
use Commercetools\Symfony\CtpBundle\Model\Search;
use GuzzleHttp\Psr7\Uri;
use Symfony\Component\HttpFoundation\Request;

class ProductRepository
{
    private $client;
    private $searchModel;

    public function __construct(Client $client, Search $searchModel)
    {
        $this->client = $client;
        $this->searchModel = $searchModel;
    }

    /**
     * @param Request $request
     * @return PagedSearchResponse
     */
    public function getProducts(Request $request = null)
    {
        $searchRequest = ProductProjectionSearchRequest::of()->currency('EUR');
        if (!is_null($request)) {
            $uri = new Uri($request->getRequestUri());
            $searchRequest = $this->getSearchRequest($searchRequest, $uri);
        }

        $response = $this->client->execute($searchRequest);

        return $response;
    }


    /**
     * @param string $productId
     * @return ProductProjection
     */
    public function getProductById($productId)
    {
        $request = ProductProjectionByIdGetRequest::ofId($productId)->currency('EUR');
        $response = $this->client->execute($request);
        $product = $request->mapFromResponse($response);

        return $product;
    }

    /**
     * @param ProductProjectionSearchRequest $request
     * @param Uri $uri
     * @return ProductProjectionSearchRequest
     */
    public function getSearchRequest(ProductProjectionSearchRequest $request, Uri $uri)
    {
        $searchValues = $this->searchModel->getSelectedValues($uri);
        $request = $this->searchModel->addFacets($request, $searchValues);

//        $request->addFacet(
//            Facet::ofName('variants.attributes.color.key')->setAlias('color')
//        );
//        $request->addFacet(
//            Facet::ofName('variants.attributes.commonSize.key')->setAlias('size')
//        );
//
//        $searchValues = [];
//        $queryParams = \GuzzleHttp\Psr7\parse_query($uri->getQuery());
//        foreach ($queryParams as $paramName => $params) {
//            switch ($paramName) {
//                case 'color':
//                    $request->addFilterFacets(
//                        Filter::ofName('variants.attributes.color.key')->setValue($params)
//                    );
//                    $request->addFilter(
//                        Filter::ofName('variants.attributes.color.key')->setValue($params)
//                    );
//                    break;
//                case 'size':
//                    $request->addFilterFacets(
//                        Filter::ofName('variants.attributes.commonSize.key')->setValue($params)
//                    );
//                    $request->addFilter(
//                        Filter::ofName('variants.attributes.commonSize.key')->setValue($params)
//                    );
//                    break;
//            }
//        }

        return $request;
    }
}
