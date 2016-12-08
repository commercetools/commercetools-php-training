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
use Commercetools\TrainingBundle\Tests\TrainingTestCase;

class CartRepositoryTest extends TrainingTestCase
{
    public function testCreateCart()
    {
        $repository = $this->container->get('commercetools_training.service.cart_repository');

        $cartDraft = CartDraft::ofCurrency('EUR')->setShippingAddress(Address::of()->setCountry('DE'));

        $cart = $repository->createCart($cartDraft);

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotNull($cart->getId());
    }

    public function testAddLineItem()
    {
        $repository = $this->container->get('commercetools_training.service.cart_repository');

        $cartDraft = CartDraft::ofCurrency('EUR')->setShippingAddress(Address::of()->setCountry('DE'));

        $createCart = $repository->createCart($cartDraft);

        $productRepository = $this->container->get('commercetools_training.service.product_repository');

        $product = $productRepository->getProducts()->current();

        $cart = $repository->addLineItem($createCart, $product->getId(), $product->getMasterVariant()->getId(), 1);
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotSame($createCart->getId(), $cart->getId());
        $this->assertCount(1, $cart->getLineItemCount());
    }

    public function testChangeLineItemQuantity()
    {
        $repository = $this->container->get('commercetools_training.service.cart_repository');
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
        $createCart = $repository->createCart($cartDraft);

        $cart = $repository->changeLineItemQuantity($createCart, $createCart->getLineItems()->current()->getId(), 2);
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotSame($createCart->getId(), $cart->getId());
        $this->assertCount(2, $cart->getLineItemCount());
        $this->assertSame(2, $createCart->getLineItems()->current()->getQuantity());
    }

    public function testRemoveLineItem()
    {
        $repository = $this->container->get('commercetools_training.service.cart_repository');
        $productRepository = $this->container->get('commercetools_training.service.product_repository');
        $product = $productRepository->getProducts()->current();

        $cartDraft = CartDraft::ofCurrency('EUR')->setShippingAddress(Address::of()->setCountry('DE'));
        $cartDraft->setLineItems(
            LineItemDraft::of()->setProductId($product->getId())
                ->setVariantId($product->getMasterVariant()->getId())
                ->setQuantity(1)
        );
        $createCart = $repository->createCart($cartDraft);

        $cart = $repository->removeLineItem($createCart, $createCart->getLineItems()->current()->getId());
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotSame($createCart->getId(), $cart->getId());
        $this->assertCount(0, $cart->getLineItemCount());
        $this->assertCount(0, $createCart->getLineItems());
    }

    public function testGetCart()
    {
        $repository = $this->container->get('commercetools_training.service.cart_repository');

        $cartDraft = CartDraft::ofCurrency('EUR')->setShippingAddress(Address::of()->setCountry('DE'));

        $createCart = $repository->createCart($cartDraft);

        $this->assertInstanceOf(Cart::class, $createCart);
        $this->assertNotNull($createCart->getId());

        $cart = $repository->getCart($createCart->getId());

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertSame($createCart->getId(), $cart->getId());
    }

    public function testGetOrCreateCart()
    {
        $typeRepository = $this->container->get('commercetools_training.service.type_repository');
        $checkReserveType = $typeRepository->getCheckReserveType();

        $repository = $this->container->get('commercetools_training.service.cart_repository');
        
        $cart = $repository->getOrCreateCart();
        
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotNull($cart->getId());
        
        $this->assertSame($checkReserveType->getId(), $cart->getCustom()->getType()->getId());
    }
}
