<?php

namespace Commercetools\Training;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Customer\Customer;
use Commercetools\Core\Model\Customer\CustomerSigninResult;
use Commercetools\Core\Model\Customer\CustomerToken;

class CustomerService extends AbstractService
{
    /**
     * @param $email
     * @param $password
     * @return CustomerSigninResult
     * @throws \Commercetools\Core\Error\ApiException
     * @throws \Commercetools\Core\Error\InvalidTokenException
     */
    public function createCustomer($email, $password)
    {
        //TODO: create customer create request
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param Customer $customer
     * @param $ttlInMinutes
     * @return CustomerToken
     * @throws \Commercetools\Core\Error\ApiException
     * @throws \Commercetools\Core\Error\InvalidTokenException
     */
    public function createEmailVerificationToken(Customer $customer, $ttlInMinutes)
    {
        //TODO: create email token request
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param CustomerToken $customerToken
     * @return Customer
     * @throws \Commercetools\Core\Error\ApiException
     * @throws \Commercetools\Core\Error\InvalidTokenException
     */
    public function verifyEmail(CustomerToken $customerToken)
    {
        //TODO: create email verification request
        $request = null;

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
