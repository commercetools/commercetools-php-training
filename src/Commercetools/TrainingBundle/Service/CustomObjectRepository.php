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
        $object = CustomObjectDraft::ofContainerKeyAndValue($container, $key, $value);
        if (!is_null($version)) {
            $object->setVersion($version);
        }
        $request = CustomObjectCreateRequest::ofObject($object);
        $response = $this->client->execute($request);

        return $request->mapFromResponse($response);
    }

    /**
     * @return CustomObject
     */
    public function getOrderNumberObject()
    {
        $request = CustomObjectByKeyGetRequest::ofContainerAndKey('stuff', 'orderNumber');
        $response = $this->client->execute($request);
        $customObject = $request->mapFromResponse($response);

        if (is_null($customObject)) {
            $customObject = CustomObjectDraft::ofContainerKeyAndValue('stuff', 'orderNumber', 0);
        }

        return $customObject;
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

        $newCustomerNumber = $customObject->getValue() + 1;
        $customObject->setValue($newCustomerNumber);

        $request = CustomObjectCreateRequest::ofObject($customObject);
        $response = $this->client->execute($request);

        $retries = 0;
        while ($retries < 5 && $response->isError()) {
            $error = $response->getErrors()->getByCode(ConcurrentModificationError::CODE);
            if ($error instanceof ConcurrentModificationError) {
                $customObject = $this->getOrderNumberObject();
                $newCustomerNumber = $customObject->getValue() + 1;
                $customObject->setValue($newCustomerNumber);
                usleep(10000);
                $request = CustomObjectCreateRequest::ofObject($customObject);
                $response = $this->client->execute($request);
            } else {
                throw new \Exception('something happened');
            }
        }

        $customObject = $request->mapFromResponse($response);

        return $customObject->getValue();
    }
}
