<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;


use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Cart\CartDraft;
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
}
