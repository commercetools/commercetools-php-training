<?php

namespace Commercetools\Training\Tests;

use Commercetools\Core\Client;
use Commercetools\Core\Helper\Uuid;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Core\Request\PsrRequest;
use Commercetools\Training\CartService;
use Commercetools\Training\ClientService;
use Commercetools\Training\CustomerService;
use Commercetools\Training\ProductQueryService;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class ProductQueryServiceTest extends TestCase
{
    public function testAddProductOnSaleToCart()
    {
        $client = (new ClientService())->createClient();
        $cartService = new CartService($client);

        $email = sprintf("%s@example.com", Uuid::uuidv4());

//        $customerService = new CustomerService($client);
//        $cart = $cartService->createCart($customerService->createCustomer($email, "password")->getCustomer());

        $service = new ProductQueryService($client);

        $products = $service->findProductsWithCategory('en', 'Sale');
        $this->assertInstanceOf(ProductProjectionCollection::class, $products);
        $this->assertInstanceOf(ProductProjection::class, $products->current());

//        $cart = $cartService->addProductToCart($products->current(), $cart);
//        $this->assertCount(1, $cart->getLineItems());
    }

    public function testPSRRequest()
    {
        $config = (new ClientService())->loadConfig();
        $config->setApiUrl('https://ml-eu.europe-west1.gcp.commercetools.com');
        $client = Client::ofConfig($config);

        $request = PsrRequest::ofRequest(
            new Request(
                'get',
                '/'. $config->getProject() .'/recommendations/general-categories?productName="black cat"'
            )
        );
        $response = $client->execute($request);

        $this->assertFalse($response->isError());
    }
}
