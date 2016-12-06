<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 */

namespace Commercetools\TrainingBundle\Tests;

use Symfony\Component\DependencyInjection\Container;

class TrainingTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;
    private $app;

    public function setUp()
    {
        $this->app = new \AppKernel('test', true);
        $this->app->boot();

        $this->container = $this->app->getContainer();
    }
}
