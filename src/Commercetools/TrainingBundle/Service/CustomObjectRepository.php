<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Error\ConcurrentModificationError;
use Commercetools\Core\Model\CustomObject\CustomObject;
use Commercetools\Core\Model\CustomObject\CustomObjectDraft;
use Commercetools\Core\Request\CustomObjects\CustomObjectByKeyGetRequest;
use Commercetools\Core\Request\CustomObjects\CustomObjectCreateRequest;

class CustomObjectRepository
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $value
     * @return CustomObject
     */
    public function store($container, $key, $value, $version = null)
    {
        //TODO 6.1.
    }

    /**
     * @return CustomObject
     */
    public function getOrderNumberObject()
    {
        //TODO 6.2.
        return null;
    }

    /**
     * @param null $customObject
     * @return int
     */
    public function getNewOrderNumber($customObject = null)
    {
        if (is_null($customObject)) {
            $customObject = $this->getOrderNumberObject();
        }

        return $customObject->getValue();
        //TODO 6.3.
    }
}
