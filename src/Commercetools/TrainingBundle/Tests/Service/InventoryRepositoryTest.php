<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;

use Commercetools\Core\Model\Inventory\InventoryDraft;
use Commercetools\Core\Model\Inventory\InventoryEntry;
use Commercetools\TrainingBundle\Tests\TrainingTestCase;

class InventoryRepositoryTest extends TrainingTestCase
{
    public function testCreateInventory()
    {
        $repository = $this->container->get('commercetools_training.service.inventory_repository');

        $inventoryDraft = InventoryDraft::ofSkuAndQuantityOnStock('ABCDE'.time(), 1);
        $inventory = $repository->createInventory($inventoryDraft);

        $this->assertInstanceOf(InventoryEntry::class, $inventory);
        $this->assertNotNull($inventory->getId());
        $this->assertSame($inventoryDraft->getSku(), $inventory->getSku());
        $this->assertSame($inventoryDraft->getQuantityOnStock(), $inventory->getQuantityOnStock());
    }
}
