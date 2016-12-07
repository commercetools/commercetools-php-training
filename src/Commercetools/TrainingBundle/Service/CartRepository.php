<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Cart\CartDraft;

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
        return null;
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
        return null;
    }

    /**
     * @param Cart $cart
     * @param $lineItemId
     * @param $quantity
     * @return Cart
     */
    public function changeLineItemQuantity(Cart $cart, $lineItemId, $quantity)
    {
        return null;
    }

    /**
     * @param Cart $cart
     * @param $lineItemId
     * @return Cart
     */
    public function removeLineItem(Cart $cart, $lineItemId)
    {
        return null;
    }

    /**
     * @param $cartId
     * @return Cart
     */
    public function getCart($cartId)
    {
        return null;
    }
}
