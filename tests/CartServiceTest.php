<?php

namespace Commercetools\Training\Tests;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Helper\Uuid;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Training\CartService;
use Commercetools\Training\ClientService;
use Commercetools\Training\CustomerService;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    public function testCartService()
    {
        $client = (new ClientService())->createClient();
        $service = new CartService($client);

        $email = sprintf("%s@example.com", Uuid::uuidv4());

        $customerService = new CustomerService($client);
        $cart = $service->createCart($customerService->createCustomer($email, "password")->getCustomer());

        $this->assertInstanceOf(Cart::class, $cart);

        $productRequest = RequestBuilder::of()->productProjections()->query();
        $response = $client->execute($productRequest);
        $product = $productRequest->mapFromResponse($response)->current();

        $cart = $service->addProductToCart($product, $cart);
        $this->assertCount(1, $cart->getLineItems());
    }
}
