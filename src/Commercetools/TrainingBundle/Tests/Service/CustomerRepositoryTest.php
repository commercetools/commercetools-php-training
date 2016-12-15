<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */


namespace Commercetools\TrainingBundle\Tests\Service;


use Commercetools\Core\Model\Common\Address;
use Commercetools\Core\Model\Common\AddressCollection;
use Commercetools\Core\Model\Customer\Customer;
use Commercetools\Core\Model\Customer\CustomerDraft;
use Commercetools\TrainingBundle\Tests\TrainingTestCase;

class CustomerRepositoryTest extends TrainingTestCase
{
    public function testCreateCustomer()
    {
        $repository = $this->container->get('commercetools_training.service.customer_repository');

        $draft = CustomerDraft::ofEmailNameAndPassword(
            'jens+' . time() . '@example.com',
            'Jens',
            'Schulze',
            '12345678'
        )->setAddresses(
            AddressCollection::of()->add(
                Address::of()->setCity('Berlin')
                    ->setCountry('DE')
                    ->setStreetName('Sonnenallee')
                    ->setStreetNumber('223')
                    ->setPostalCode('12529')
            )
        )
        ;

        $customer = $repository->createCustomer($draft);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertNotNull($customer->getId());
        $this->assertSame($draft->getEmail(), $customer->getEmail());
    }
}
