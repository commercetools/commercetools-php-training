<?php

namespace Commercetools\Training;

use Commercetools\Core\Client;
use Commercetools\Core\Config;

class ClientService
{
    /**
     * @return Client
     */
    public function createClient()
    {
        //TODO: 1.1 instantiate client
        return null;
    }

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

        return Config::fromArray($config);
    }
}
