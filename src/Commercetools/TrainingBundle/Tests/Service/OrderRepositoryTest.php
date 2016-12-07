<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;

use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Cart\CartDraft;
use Commercetools\Core\Model\Cart\LineItemDraft;
use Commercetools\Core\Model\Cart\LineItemDraftCollection;
use Commercetools\Core\Model\Common\Address;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Order\ImportOrder;
use Commercetools\Core\Model\Order\LineItemImportDraft;
use Commercetools\Core\Model\Order\LineItemImportDraftCollection;
use Commercetools\Core\Model\Order\Order;
use Commercetools\Core\Model\Order\ProductVariantImportDraft;
use Commercetools\TrainingBundle\Tests\TrainingTestCase;

class OrderRepositoryTest extends TrainingTestCase
{
    public function testCreateOrder()
    {
        $cartRepository = $this->container->get('commercetools_training.service.cart_repository');
        $productRepository = $this->container->get('commercetools_training.service.product_repository');
        $product = $productRepository->getProducts()->current();

        $cartDraft = CartDraft::ofCurrency('EUR')->setShippingAddress(Address::of()->setCountry('DE'));
        $cartDraft->setLineItems(
            LineItemDraftCollection::of()->add(
                LineItemDraft::of()->setProductId($product->getId())
                   ->setVariantId($product->getMasterVariant()->getId())
                    ->setQuantity(1)
            )
        );

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
        $productRepository = $this->container->get('commercetools_training.service.product_repository');
        $product = $productRepository->getProducts()->current();

        $importOrder = ImportOrder::of();
        $importOrder->setTotalPrice(Money::ofCurrencyAndAmount('EUR', 100));
        $importOrder->setLineItems(
            LineItemImportDraftCollection::of()->add(
                LineItemImportDraft::of()
                    ->setProductId($product->getId())
                    ->setVariant(
                        ProductVariantImportDraft::of()
                            ->setId($product->getMasterVariant()->getId())
                    )
                    ->setPrice($product->getMasterVariant()->getPrices()->current())
                    ->setQuantity(1)
                    ->setName($product->getName())
            )
        );
        $order = $orderRepository->importOrder($importOrder);
        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotNull($order->getId());
        $this->assertSame($importOrder->getTotalPrice()->getCurrencyCode(), $order->getTotalPrice()->getCurrencyCode());
        $this->assertSame($importOrder->getTotalPrice()->getCentAmount(), $order->getTotalPrice()->getCentAmount());
        $this->assertCount(1, $importOrder->getLineItems());
        $this->assertSame($product->getId(), $importOrder->getLineItems()->current()->getProductId());
    }
}
