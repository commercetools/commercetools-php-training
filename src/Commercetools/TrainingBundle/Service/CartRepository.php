<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Cart\CartDraft;
use Commercetools\Core\Model\Cart\LineItem;
use Commercetools\Core\Model\Cart\LineItemCollection;
use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Common\Price;
use Commercetools\Core\Model\Common\TaxedPrice;

class CartRepository
{
    private $client;
    private $types;

    public function __construct(Client $client, TypeRepository $types)
    {
        $this->client = $client;
        $this->types = $types;
    }

    /**
     * @param CartDraft $cartDraft
     * @return Cart
     */
    public function createCart(CartDraft $cartDraft)
    {
        return $this->getFakeCart();
    }

    /**
     * @param Cart $cart
     * @param $productId
     * @param $variantId
     * @param $quantity
     * @return Cart
     */
    public function addLineItem(Cart $cart, $productId, $variantId, $quantity)
    {
        return $this->getFakeCart();
    }

    /**
     * @param Cart $cart
     * @param $lineItemId
     * @param $quantity
     * @return Cart
     */
    public function changeLineItemQuantity(Cart $cart, $lineItemId, $quantity)
    {
        return $this->getFakeCart();
    }

    /**
     * @param Cart $cart
     * @param $lineItemId
     * @return Cart
     */
    public function removeLineItem(Cart $cart, $lineItemId)
    {
        return $this->getFakeCart();
    }

    /**
     * @param $cartId
     * @return Cart
     */
    public function getCart($cartId)
    {
        return $this->getFakeCart();
    }

    /**
     * @param null $cartId
     * @return Cart
     */
    public function getOrCreateCart($cartId = null)
    {
        return $this->getFakeCart();
    }

    private function getFakeCart()
    {
        return Cart::of()
            ->setLineItems(
                LineItemCollection::of()->add(
                    LineItem::of()
                        ->setId('12345678')
                        ->setName(LocalizedString::ofLangAndText('en', 'Test'))
                        ->setPrice(Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100)))
                        ->setTotalPrice(Money::ofCurrencyAndAmount('EUR', 100))
                )
            )
            ->setTotalPrice(Money::ofCurrencyAndAmount('EUR', 116))
            ->setTaxedPrice(
                TaxedPrice::of()
                    ->setTotalGross(Money::ofCurrencyAndAmount('EUR', 116))
                    ->setTotalNet(Money::ofCurrencyAndAmount('EUR', 100))
            )
        ;
    }
}
