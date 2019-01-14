<?php

namespace Commercetools\Training\Tests;

use Commercetools\Training\ClientService;
use Commercetools\Training\ProductSearchService;
use PHPUnit\Framework\TestCase;

class ProductSearchServiceTest extends TestCase
{
    public function testFulltextSearch()
    {
        $client = (new ClientService())->createClient();
        $service = new ProductSearchService($client);

        $result = $service->fulltextSearch('en', 'Cantarelli');

        $this->assertGreaterThan(0, $result->count());
        $this->assertContains('Cantarelli', $result->current()->getName()->en);
    }

    public function testFacetSearch()
    {
        $client = (new ClientService())->createClient();
        $service = new ProductSearchService($client);

        $result = $service->facetSearch('ctp-color', 'red');

        $this->assertGreaterThan(0, $result->count());
        $this->assertSame(
            'red',
            $result->current()->getMasterVariant()->getAttributes()->getByName('ctp-color')->getValueAsString()
        );
    }
}
