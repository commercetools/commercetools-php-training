<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Client;
use Commercetools\Core\Model\Order\OrderReference;
use Commercetools\Core\Model\Subscription\ChangeSubscription;
use Commercetools\Core\Model\Subscription\ChangeSubscriptionCollection;
use Commercetools\Core\Model\Subscription\Destination;
use Commercetools\Core\Model\Subscription\MessageSubscriptionCollection;
use Commercetools\Core\Model\Subscription\SQSDestination;
use Commercetools\Core\Model\Subscription\Subscription;
use Commercetools\Core\Model\Subscription\SubscriptionDraft;

class SubscriptionService extends AbstractService
{
    private $region;
    private $queueUrl;

    public function __construct(Client $client, $region, $queueUrl)
    {
        parent::__construct($client);
        $this->region = $region;
        $this->queueUrl = $queueUrl;
    }

    /**
     * @return Subscription
     */
    public function createSqsSubscription()
    {
        //TODO: 9.1 create subscription request
        $draft = SubscriptionDraft::ofDestinationAndChanges(
            SQSDestination::ofQueueURLAccessKeyAndSecret($this->queueUrl, $_SERVER['SQS_ACCESS_KEY'], $_SERVER['SQS_ACCESS_SECRET'])
                ->setRegion($this->region),
            $this->changeSubscriptionOrderChanges()
        );
        $request = RequestBuilder::of()->subscriptions()->create($draft);

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param Subscription $subscription
     * @return Subscription
     */
    public function deleteSqsSubscription(Subscription $subscription)
    {
        //TODO: 9.2 delete subscription request
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @return ChangeSubscriptionCollection
     */
    private function changeSubscriptionOrderChanges()
    {
        return ChangeSubscriptionCollection::of()
            ->add(ChangeSubscription::of()->setResourceTypeId(OrderReference::TYPE_ORDER));
    }
}
