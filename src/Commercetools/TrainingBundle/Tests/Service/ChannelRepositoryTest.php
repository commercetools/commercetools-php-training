<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;

use Commercetools\Core\Model\Channel\Channel;
use Commercetools\Core\Model\Channel\ChannelCollection;
use Commercetools\Core\Model\Channel\ChannelDraft;
use Commercetools\Core\Model\CustomField\CustomFieldObjectDraft;
use Commercetools\Core\Model\CustomField\FieldContainer;
use Commercetools\Core\Model\Type\Type;
use Commercetools\TrainingBundle\Tests\TrainingTestCase;

class ChannelRepositoryTest extends TrainingTestCase
{
    public function testCreateChannel()
    {
        $repository = $this->container->get('commercetools_training.service.channel_repository');

        $channelDraft = ChannelDraft::ofKey('training' . time());

        $channel = $repository->createChannel($channelDraft);
        $this->assertInstanceOf(Channel::class, $channel);
        $this->assertNotNull($channel->getId());
        $this->assertSame($channelDraft->getKey(), $channel->getKey());
    }

    public function testGetChannel()
    {
        $repository = $this->container->get('commercetools_training.service.channel_repository');

        $channelDraft = ChannelDraft::ofKey('training' . time());

        $createChannel = $repository->createChannel($channelDraft);

        $channel = $repository->getChannel($channelDraft->getKey());
        $this->assertInstanceOf(Channel::class, $channel);
        $this->assertSame($createChannel->getId(), $channel->getId());
    }

    public function testQueryChannels()
    {
        $repository = $this->container->get('commercetools_training.service.type_repository');
        /**
         * @var Type $type
         */
        $type = $repository->getGeoType();

        $repository = $this->container->get('commercetools_training.service.channel_repository');

        $channelDraft = ChannelDraft::ofKey('training' . time());
        $channelDraft->setCustom(
            CustomFieldObjectDraft::ofTypeKey($type->getKey())
                ->setFields(FieldContainer::of()->setLat(52.520007)->setLng(13.404954))
        );

        $createChannel = $repository->createChannel($channelDraft);

        $channels = $repository->queryChannelsByBound(52, 13, 53, 14);

        $this->assertInstanceOf(ChannelCollection::class, $channels);
        $channel = $channels->getById($createChannel->getId());
        $this->assertInstanceOf(Channel::class, $channel);
    }
}
