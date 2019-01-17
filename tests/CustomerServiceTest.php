<?php

namespace Commercetools\Training\Tests;

use Commercetools\Core\Helper\Uuid;
use Commercetools\Core\Model\Customer\Customer;
use Commercetools\Core\Model\Customer\CustomerSigninResult;
use Commercetools\Core\Model\Customer\CustomerToken;
use Commercetools\Training\ClientService;
use Commercetools\Training\CustomerService;
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    public function testRegisterCustomer()
    {
        $client = (new ClientService())->createClient();
        $service = new CustomerService($client);

        $email = sprintf("%s@example.com", Uuid::uuidv4());

        $result = $service->createCustomer($email, "password");
        $this->assertInstanceOf(CustomerSigninResult::class, $result);

        $token = $service->createEmailVerificationToken($result->getCustomer(), 5);
        $this->assertInstanceOf(CustomerToken::class, $token);

        $customer = $service->verifyEmail($token);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testVerifyCustomerEmail()
    {
        $client = (new ClientService())->createClient();
        $service = new CustomerService($client);

        $result = $service->getById("f5055386-caf7-43ad-bac5-9682e0dd56aa");
        $this->assertInstanceOf(Customer::class, $result);

        $token = $service->createEmailVerificationToken($result, 5);
        $this->assertInstanceOf(CustomerToken::class, $token);

        $customer = $service->verifyEmail($token);
        $this->assertInstanceOf(Customer::class, $customer);

    }
}
