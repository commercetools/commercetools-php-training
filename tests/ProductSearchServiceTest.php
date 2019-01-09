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
        $this->assertSame('Cantarelli', $result->current()->getName()->en);
    }

    public function testFacetSearch()
    {
        $client = (new ClientService())->createClient();
        $service = new ProductSearchService($client);

        $result = $service->facetSearch('color', 'red');

        $this->assertGreaterThan(0, $result->count());
        $this->assertSame(
            'red',
            $result->current()->getMasterVariant()->getAttributes()->getByName('color')->getValueAsString()
        );
    }
}
