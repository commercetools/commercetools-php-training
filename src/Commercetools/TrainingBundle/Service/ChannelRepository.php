<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Channel\Channel;
use Commercetools\Core\Model\Channel\ChannelCollection;
use Commercetools\Core\Model\Channel\ChannelDraft;

class ChannelRepository
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $key
     * @return Channel
     */
    public function getChannel($key)
    {
        //TODO 7.2.
        return null;
    }

    /**
     * @param ChannelDraft $channelDraft
     * @return Channel
     */
    public function createChannel(ChannelDraft $channelDraft)
    {
        //TODO 7.1.
        return null;
    }

    /**
     * @param $lng
     * @param $lat
     * @param $distance
     * @return ChannelCollection
     */
    public function queryChannelsAtLocation($lng, $lat, $distance)
    {
        //TODO 7.3.
        return null;
    }
}
