<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Order\ImportOrder;
use Commercetools\Core\Model\Order\Order;

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
        return null;
    }

    /**
     * @param Cart $cart
     * @return Order
     */
    public function createOrder(Cart $cart)
    {
        return null;
    }
}
