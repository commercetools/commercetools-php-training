<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;

use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Cart\CartDraft;
use Commercetools\Core\Model\Common\Address;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Order\ImportOrder;
use Commercetools\Core\Model\Order\Order;
use Commercetools\TrainingBundle\Tests\TrainingTestCase;

class OrderRepositoryTest extends TrainingTestCase
{
    public function testCreateOrder()
    {
        $cartRepository = $this->container->get('commercetools_training.service.cart_repository');

        $cartDraft = CartDraft::ofCurrency('EUR')->setShippingAddress(Address::of()->setCountry('DE'));

        $cart = $cartRepository->createCart($cartDraft);

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotNull($cart->getId());

        $orderRepository = $this->container->get('commercetools_training.service.order_repository');

        $order = $orderRepository->createOrder($cart);
        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotNull($order->getId());
    }

    public function testImportOrder()
    {
        $orderRepository = $this->container->get('commercetools_training.service.order_repository');

        $importOrder = ImportOrder::of();
        $importOrder->setTotalPrice(Money::ofCurrencyAndAmount('EUR', 100));
        $order = $orderRepository->importOrder($importOrder);
        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotNull($order->getId());
        $this->assertSame($importOrder->getTotalPrice()->getCurrencyCode(), $order->getTotalPrice()->getCurrencyCode());
        $this->assertSame($importOrder->getTotalPrice()->getCentAmount(), $order->getTotalPrice()->getCentAmount());
    }
}
