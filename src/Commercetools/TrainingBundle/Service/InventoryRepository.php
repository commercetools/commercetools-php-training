<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Inventory\InventoryDraft;
use Commercetools\Core\Model\Inventory\InventoryEntry;

class InventoryRepository
{
    private $client;
    private $channels;

    public function __construct(Client $client, ChannelRepository $channels)
    {
        $this->client = $client;
        $this->channels = $channels;
    }

    /**
     * @param $sku
     * @return InventoryEntry
     */
    public function getInventory($sku)
    {
        //TODO 8.2.
        return null;
    }

    /**
     * @param InventoryDraft $inventoryDraft
     * @return InventoryEntry
     */
    public function createInventory(InventoryDraft $inventoryDraft)
    {
        //TODO 8.1.
        return null;
    }
}
