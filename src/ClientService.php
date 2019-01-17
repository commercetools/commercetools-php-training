<?php

namespace Commercetools\Training;

use Commercetools\Core\Client;
use Commercetools\Core\Config;
use Commercetools\Core\Model\Common\Context;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ClientService
{
    /**
     * @return Client
     */
    public function createClient()
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('./requests.log'));

        return Client::ofConfigAndLogger($this->loadConfig(), $log);
    }

    /**
     * @return Config
     */
    public function loadConfig()
    {
        $parameters = [];
        if (!isset($_SERVER['CTP_CLIENT_ID']) && file_exists(__DIR__ . '/../parameters.env')) {
            $envFile = file(__DIR__ . '/../parameters.env');
            $envFile = array_map('trim',$envFile);
            $envVars = array_map(function ($value) { return explode("=", $value, 2); }, $envFile);
            $parameters = array_combine(
                array_column($envVars, 0),
                array_column($envVars, 1)
            );
        }
        $config = [
            'client_id' => isset($_SERVER['CTP_CLIENT_ID']) ? $_SERVER['CTP_CLIENT_ID'] : $parameters['CTP_CLIENT_ID'],
            'client_secret' => isset($_SERVER['CTP_CLIENT_SECRET']) ? $_SERVER['CTP_CLIENT_SECRET'] : $parameters['CTP_CLIENT_SECRET'],
            'project' => isset($_SERVER['CTP_PROJECT']) ? $_SERVER['CTP_PROJECT'] : $parameters['CTP_PROJECT']
        ];

        $context = Context::of()->setLanguages(['en']);
        return Config::fromArray($config)->setContext($context);
    }
}
