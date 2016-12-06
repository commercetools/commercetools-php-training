<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;

use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Type\FieldDefinition;
use Commercetools\Core\Model\Type\NumberType;
use Commercetools\Core\Model\Type\Type;
use Commercetools\Core\Model\Type\TypeDraft;
use Commercetools\TrainingBundle\Tests\TrainingTestCase;

class TypeRepositoryTest extends TrainingTestCase
{
    public function testGetGeoType()
    {
        $repository = $this->container->get('commercetools_training.service.type_repository');
        /**
         * @var Type $type
         */
        $type = $repository->getGeoType();

        $this->assertInstanceOf(Type::class, $type);
        $this->assertSame('geoType', $type->getKey());
        $this->assertInstanceOf(
            FieldDefinition::class,
            $type->getFieldDefinitions()->getByName('lat')
        );
        $this->assertInstanceOf(
            NumberType::class,
            $type->getFieldDefinitions()->getByName('lat')->getType()
        );
        $this->assertInstanceOf(
            FieldDefinition::class,
            $type->getFieldDefinitions()->getByName('lng')
        );
        $this->assertInstanceOf(
            NumberType::class,
            $type->getFieldDefinitions()->getByName('lng')->getType()
        );
    }

    public function testGetOrderType()
    {
        $repository = $this->container->get('commercetools_training.service.type_repository');
        /**
         * @var Type $type
         */
        $type = $repository->getOrderType();

        $this->assertInstanceOf(Type::class, $type);
        $this->assertSame('orderType', $type->getKey());
    }

    public function testCreateType()
    {
        $repository = $this->container->get('commercetools_training.service.type_repository');

        $typeDraft = TypeDraft::ofKeyNameDescriptionAndResourceTypes(
            'trainingType'.time(),
            LocalizedString::ofLangAndText('en', 'Training Type'),
            LocalizedString::ofLangAndText('en', 'Training Type'),
            ['product']
        );
        $type = $repository->createType($typeDraft);

        $this->assertInstanceOf(Type::class, $type);
        $this->assertNotNull($type->getId());
    }
}
