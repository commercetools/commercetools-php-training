<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Update\ActionBuilder;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Customer\Customer;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Request\Carts\CartUpdateRequest;

class CartService extends AbstractService
{
    /**
     * @param Customer $customer
     * @return Cart
     */
    public function createCart(Customer $customer)
    {
        //TODO: 3.1 create cart request
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);

    }

    /**
     * @param ProductProjection $product
     * @param Cart $cart
     * @return Cart
     */
    public function addProductToCart(ProductProjection $product, Cart $cart)
    {
        //TODO: 3.1 update cart with product
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param string $code
     * @param Cart $cart
     * @return Cart
     */
    public function addDiscountToCart($code, Cart $cart)
    {
        //TODO: 5.1 add discount to cart
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
