<?php

namespace Commercetools\Training\Test;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Client;
use Commercetools\Core\Config;
use Commercetools\Core\Model\Project\Project;
use Commercetools\Training\ClientService;
use PHPUnit\Framework\TestCase;

class ClientServiceTest extends TestCase
{
    public function testLoadConfig()
    {
        $config = (new ClientService())->loadConfig();
        $this->assertInstanceOf(Config::class, $config);
    }

    public function testCreateClient()
    {
        $client = (new ClientService())->createClient();

        $this->assertInstanceOf(Client::class, $client);
    }

    public function testGetProject()
    {
        $client = (new ClientService())->createClient();
        $request = RequestBuilder::of()->project()->get();
        $response = $client->execute($request);
        $project = $request->mapFromResponse($response);

        $this->assertInstanceOf(Project::class, $project);
    }

    public function testGraphQL()
    {
        $client = (new ClientService())->createClient();
        $request = RequestBuilder::of()->graphQL()->query();
        $request->query("query Sphere {
  products {
    results {
      masterData {
        current {
          masterVariant {
            id
          }
        }
      }
    }
  }
}")->setVariables(['test' => 'test']);
        $response = $client->execute($request);
        $this->assertFalse($response->isError());
    }
}
