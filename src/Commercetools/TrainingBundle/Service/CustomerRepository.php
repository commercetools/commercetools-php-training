<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Service;

use Commercetools\Core\Client;
use Commercetools\Core\Model\Customer\CustomerDraft;
use Commercetools\Core\Request\Customers\CustomerCreateRequest;

class CustomerRepository
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createCustomer(CustomerDraft $customer)
    {
        $request = CustomerCreateRequest::ofDraft($customer);
        $response = $this->client->execute($request);
        $customerSignInResult = $request->mapFromResponse($response);
        $customer = $customerSignInResult->getCustomer();
        $cart = $customerSignInResult->getCart();

        return $customer;
    }
}
