<?php

namespace Commercetools\Training\Tests;

use Commercetools\Core\Helper\Uuid;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Training\CartService;
use Commercetools\Training\ClientService;
use Commercetools\Training\CustomerService;
use Commercetools\Training\ProductQueryService;
use PHPUnit\Framework\TestCase;

class ProductQueryServiceTest extends TestCase
{
    public function testAddProductOnSaleToCart()
    {
        $client = (new ClientService())->createClient();
        $cartService = new CartService($client);

        $email = sprintf("%s@example.com", Uuid::uuidv4());

        $customerService = new CustomerService($client);
        $cart = $cartService->createCart($customerService->createCustomer($email, "password")->getCustomer());

        $service = new ProductQueryService($client);

        $products = $service->findProductsWithCategory('en', 'Sale');

        $this->assertInstanceOf(ProductProjectionCollection::class, $products);
        $this->assertInstanceOf(ProductProjection::class, $products->current());

        $cart = $cartService->addProductToCart($products->current(), $cart);
        $this->assertCount(1, $cart->getLineItems());
    }
}
