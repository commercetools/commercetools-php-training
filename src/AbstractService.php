<?php
/**
 * @author @jenschude <jens.schulze@commercetools.de>
 */

namespace Commercetools\Training;

use Commercetools\Core\Client;

abstract class AbstractService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
