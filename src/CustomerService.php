<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Client;
use Commercetools\Core\Model\Customer\Customer;
use Commercetools\Core\Model\Customer\CustomerDraft;
use Commercetools\Core\Model\Customer\CustomerSigninResult;
use Commercetools\Core\Model\Customer\CustomerToken;
use Commercetools\Core\Request\Customers\CustomerCreateRequest;

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
        //TODO: 2.1 create customer create request
        $request = RequestBuilder::of()->customers()->create(CustomerDraft::ofEmailNameAndPassword($email, '', '', $password));
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
        //TODO: 2.2 create email token request
        $request = RequestBuilder::of()->customers()->createEmailVerificationToken($customer, $ttlInMinutes);

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
        //TODO: 2.3 create email verification request
        $request = RequestBuilder::of()->customers()->confirmEmail($customerToken->getValue());

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    public function getById($id)
    {
        //TODO: 2.3 get customer by ID
        $request = RequestBuilder::of()->customers()->getById($id);

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
