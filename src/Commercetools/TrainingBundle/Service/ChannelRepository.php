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
    private $types;

    public function __construct(Client $client, TypeRepository $types)
    {
        $this->client = $client;
        $this->types = $types;
    }

    /**
     * @param $key
     * @return Channel
     */
    public function getChannel($key)
    {
        return null;
    }

    /**
     * @param ChannelDraft $channelDraft
     * @return Channel
     */
    public function createChannel(ChannelDraft $channelDraft)
    {
        return null;
    }

    /**
     * @param $topLat
     * @param $topLng
     * @param $bottomLat
     * @param $bottomLng
     * @return ChannelCollection
     */
    public function queryChannelsByBound($topLat, $topLng, $bottomLat, $bottomLng)
    {
        return null;
    }
}
