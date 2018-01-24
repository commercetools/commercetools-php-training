<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Order\ImportOrder;
use Commercetools\Core\Model\Order\Order;
use Commercetools\Core\Model\State\StateReference;
use Commercetools\Core\Request\Orders\Command\OrderTransitionStateAction;
use Commercetools\Core\Request\Orders\OrderCreateFromCartRequest;
use Commercetools\Core\Request\Orders\OrderImportRequest;
use Commercetools\Core\Request\Orders\OrderUpdateRequest;

class OrderRepository
{
    private $client;
    private $types;

    public function __construct(Client $client, TypeRepository $types)
    {
        $this->client = $client;
        $this->types = $types;
    }

    /**
     * @param ImportOrder $importOrder
     * @return Order
     */
    public function importOrder(ImportOrder $importOrder)
    {
        $request = OrderImportRequest::ofImportOrder($importOrder);
        $response = $this->client->execute($request);

        $order = $request->mapFromResponse($response);
        return $order;
    }

    /**
     * @param Cart $cart
     * @return Order
     */
    public function createOrder(Cart $cart)
    {
        $request = OrderCreateFromCartRequest::ofCartIdAndVersion($cart->getId(), $cart->getVersion());
        $response = $this->client->execute($request);

        $order = $request->mapFromResponse($response);
        return $order;
    }

    public function transitionOrder(Order $order, StateReference $state)
    {
        $request = OrderUpdateRequest::ofIdAndVersion($order->getId(), $order->getVersion());

        $request->addAction(
            OrderTransitionStateAction::ofState(
                $state
            )
        );

        $response = $this->client->execute($request);

        var_dump((string)$response->getBody());
        $order = $request->mapFromResponse($response);
        return $order;
    }
}
