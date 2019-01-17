<?php

namespace Commercetools\Training\Tests;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Helper\Uuid;
use Commercetools\Core\Model\Order\Order;
use Commercetools\Core\Model\Order\OrderState;
use Commercetools\Training\CartService;
use Commercetools\Training\ClientService;
use Commercetools\Training\CustomerService;
use Commercetools\Training\OrderService;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{

    public function testCreateOrder()
    {
        $client = (new ClientService())->createClient();
        $cartService = new CartService($client);

        $email = sprintf("%s@example.com", Uuid::uuidv4());

        $customerService = new CustomerService($client);
        $cart = $cartService->createCart($customerService->createCustomer($email, "password")->getCustomer());

        $productRequest = RequestBuilder::of()->productProjections()->query()->where('id = "5be2514f-fce2-4688-b2a5-cf32c8cab3fb"');
        $response = $client->execute($productRequest);
        $product = $productRequest->mapFromResponse($response)->current();

        $cart = $cartService->addProductToCart($product, $cart);

        $service = new OrderService($client);
        $order = $service->createOrder($cart);

        $this->assertInstanceOf(Order::class, $order);
    }

    public function testChangeState()
    {
        $client = (new ClientService())->createClient();
        $cartService = new CartService($client);

        $email = sprintf("%s@example.com", Uuid::uuidv4());

        $customerService = new CustomerService($client);
        $cart = $cartService->createCart($customerService->createCustomer($email, "password")->getCustomer());

        $productRequest = RequestBuilder::of()->productProjections()->query()->where('id = "5be2514f-fce2-4688-b2a5-cf32c8cab3fb"');
        $response = $client->execute($productRequest);
        $product = $productRequest->mapFromResponse($response)->current();

        $cart = $cartService->addProductToCart($product, $cart);

        $service = new OrderService($client);
        $order = $service->createOrder($cart);

        $this->assertInstanceOf(Order::class, $order);

        $order = $service->changeState(OrderState::CANCELLED, $order);
        $this->assertSame(OrderState::CANCELLED, $order->getOrderState());
    }
}
