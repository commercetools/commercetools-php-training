<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;


use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Core\Request\Products\ProductProjectionSearchRequest;
use Commercetools\TrainingBundle\Tests\TrainingTestCase;
use GuzzleHttp\Psr7\Uri;

class ProductRepositoryTest extends TrainingTestCase
{
    public function testGetSearchRequest()
    {
        $repository = $this->container->get('commercetools_training.service.product_repository');

        $request = ProductProjectionSearchRequest::of();
        $uri = new Uri('?size=35&color=green');

        $request =$repository->getSearchRequest($request, $uri);

        $this->assertInstanceOf(ProductProjectionSearchRequest::class, $request);
        $this->assertSame(
            'facet=variants.attributes.color.key+as+color&facet=variants.attributes.commonSize.key+as+size&' .
            'filter.facets=variants.attributes.color.key%3A%22green%22&' .
            'filter.facets=variants.attributes.commonSize.key%3A%2235%22&' .
            'filter=variants.attributes.color.key%3A%22green%22&filter=variants.attributes.commonSize.key%3A%2235%22',
            (string)$request->httpRequest()->getBody()
        );
    }

    public function testGetProducts()
    {
        $repository = $this->container->get('commercetools_training.service.product_repository');
        
        $products = $repository->getProducts()->toObject();

        $this->assertInstanceOf(ProductProjectionCollection::class, $products);
        $this->assertInstanceOf(ProductProjection::class, $products->current());
    }

    public function testGetProductById()
    {
        $repository = $this->container->get('commercetools_training.service.product_repository');

        $products = $repository->getProducts()->toObject();

        $this->assertInstanceOf(ProductProjection::class, $products->current());

        $product = $repository->getProductById($products->current()->getId());

        $this->assertInstanceOf(ProductProjection::class, $products->current());
        $this->assertSame($products->current()->getId(), $product->getId());
    }
}
