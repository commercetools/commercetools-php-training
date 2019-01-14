<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Order\Order;
use Commercetools\Core\Request\Orders\Command\OrderChangeOrderStateAction;

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
        $request = RequestBuilder::of()->orders()->update($order)->addAction(
            OrderChangeOrderStateAction::ofOrderState($state)
        );

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
