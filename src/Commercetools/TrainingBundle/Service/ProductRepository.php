<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Common\Image;
use Commercetools\Core\Model\Common\ImageCollection;
use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Common\Price;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Core\Model\Product\ProductVariant;
use Commercetools\Core\Request\Products\ProductProjectionSearchRequest;
use Commercetools\Core\Response\PagedSearchResponse;
use Commercetools\Symfony\CtpBundle\Model\Search;
use GuzzleHttp\Psr7\Response;
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
        $searchRequest = ProductProjectionSearchRequest::of($this->client->getConfig()->getContext())
            ->currency('EUR')
            ->fuzzy(true);
        if (!is_null($request)) {
            $uri = new Uri($request->getRequestUri());
            $searchRequest = $this->getSearchRequest($searchRequest, $uri);
        }

        return $this->getFakeSearchResult($searchRequest);
        //TODO 2.1. Query all products
    }

    /**
     * @param string $productId
     * @return ProductProjection
     */
    public function getProductById($productId)
    {
        return $this->getFakeProduct();
        //TODO 2.2. Get a product by ID.
    }

    /**
     * @param ProductProjectionSearchRequest $request
     * @param Uri $uri
     * @return ProductProjectionSearchRequest
     */
    public function getSearchRequest(ProductProjectionSearchRequest $request, Uri $uri)
    {
        return $request;
    }

    private function getFakeProduct()
    {
        $description = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
         ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea
         rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor
         sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
         aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
         gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';

        return ProductProjection::of()->setContext($this->client->getConfig()->getContext())
            ->setId('123456')
            ->setName(LocalizedString::ofLangAndText('en', 'Test'))
            ->setDescription(LocalizedString::ofLangAndText('en', $description))
            ->setMasterVariant(
                ProductVariant::of()
                    ->setPrice(
                        Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100))
                    )
                    ->setImages(
                        ImageCollection::of()->add(
                            Image::of()->setUrl(
                                'https://s3-eu-west-1.amazonaws.com/commercetools-maximilian/products/072595_1_large.jpg'
                            )
                        )
                    )
            );
    }

    private function getFakeSearchResult($searchRequest)
    {
        $facets = [
            'size' => [
                'type' => 'terms',
                'terms' => [
                    ['term' => '34', 'count' => 1, 'checked' => false],
                    ['term' => '35', 'count' => 1, 'checked' => false],
                ]
            ],
            'color' => [
                'type' => 'terms',
                'terms' => [
                    ['term' => 'blue', 'count' => 1, 'checked' => false],
                    ['term' => 'red', 'count' => 1, 'checked' => false],
                ]
            ]
        ];
        $description = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
         ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea
         rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor
         sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
         aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
         gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';

        $products = ProductProjectionCollection::of($this->client->getConfig()->getContext())
            ->add(
                ProductProjection::of()
                    ->setId('123456')
                    ->setName(LocalizedString::ofLangAndText('en', 'Test'))
                    ->setDescription(LocalizedString::ofLangAndText('en', $description))
                    ->setMasterVariant(
                        ProductVariant::of()
                            ->setPrice(
                                Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100))
                            )
                            ->setImages(
                                ImageCollection::of()->add(
                                    Image::of()->setUrl(
                                        'https://s3-eu-west-1.amazonaws.com/commercetools-maximilian/products/072595_1_large.jpg'
                                    )
                                )
                            )
                    )
            )
            ->add(
                ProductProjection::of()
                    ->setId('789012')
                    ->setName(LocalizedString::ofLangAndText('en', 'Test2'))
                    ->setDescription(LocalizedString::ofLangAndText('en', $description))
                    ->setMasterVariant(
                        ProductVariant::of()
                            ->setPrice(
                                Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100))
                            )
                            ->setImages(
                                ImageCollection::of()->add(
                                    Image::of()->setUrl(
                                        'https://s3-eu-west-1.amazonaws.com/commercetools-maximilian/products/079639_1_medium.jpg'
                                    )
                                )
                            )
                    )
            )
        ;
        $data = json_encode(['results' => $products->toArray(), 'facets' => $facets]);
        $httpResponse = new Response(200, [], $data);
        $response =  new PagedSearchResponse($httpResponse, $searchRequest, $this->client->getConfig()->getContext());

        return $response;
    }
}
