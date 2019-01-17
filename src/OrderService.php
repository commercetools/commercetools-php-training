<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Order\Order;

class OrderService extends AbstractService
{
    /**
     * @param Cart $cart
     * @return Order
     */
    public function createOrder(Cart $cart)
    {
        //TODO: 6.1 create order request
        $request = RequestBuilder::of()->orders()->createFromCart($cart);

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    public function changeState($state, Order $order)
    {
        //TODO: 7.1 change order state request
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
