<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
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
        return null;
    }


    /**
     * @param string $productId
     * @return ProductProjection
     */
    public function getProductById($productId)
    {
        return null;
    }

    /**
     * @param ProductProjectionSearchRequest $request
     * @param Uri $uri
     * @return ProductProjectionSearchRequest
     */
    public function getSearchRequest(ProductProjectionSearchRequest $request, Uri $uri)
    {
        return null;
    }
}
