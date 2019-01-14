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
use Commercetools\Training\SubscriptionService;
use PHPUnit\Framework\TestCase;

class SubscriptionServiceTest extends TestCase
{
    public function testSubscriptions()
    {
        $client = (new ClientService())->createClient();

        $subscriptionService = new SubscriptionService(
            $client,
            'eu-west-1',
            'https://sqs.eu-west-1.amazonaws.com/501843469210/tut_mko'
        );
        $subscription = $subscriptionService->createSqsSubscription();

        $cartService = new CartService($client);

        $email = sprintf("%s@example.com", Uuid::uuidv4());

        $customerService = new CustomerService($client);
        $cart = $cartService->createCart($customerService->createCustomer($email, "password")->getCustomer());

        $productRequest = RequestBuilder::of()->productProjections()->query();
        $response = $client->execute($productRequest);
        $product = $productRequest->mapFromResponse($response)->current();

        $cart = $cartService->addProductToCart($product, $cart);

        $orderService = new OrderService($client);
        $order = $orderService->createOrder($cart);

        $this->assertInstanceOf(Order::class, $order);

        $order = $orderService->changeState(OrderState::CANCELLED, $order);
        $this->assertSame(OrderState::CANCELLED, $order->getOrderState());

        $subscriptionService->deleteSqsSubscription($subscription);
    }
}
