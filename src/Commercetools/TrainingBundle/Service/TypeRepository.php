<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Type\Type;
use Commercetools\Core\Model\Type\TypeDraft;

class TypeRepository
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Type
     */
    public function getGeoType()
    {
        return null;
    }

    /**
     * @return Type
     */
    public function getOrderType()
    {
        return null;
    }

    /**
     * @param TypeDraft $type
     * @return Type
     */
    public function createType(TypeDraft $type)
    {
        return null;
    }
}
