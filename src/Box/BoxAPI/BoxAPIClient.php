<?php

namespace Box\BoxAPI;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Box\Plugin\Oauth2\Oauth2Plugin;

/**
 * My example web service client
 */
class BoxAPIClient extends Client
{
    /**
     * Factory method to create a new BoxAPIClient
     *
     * The following array keys and values are available options:
     * - token: Bearer token for OAUTH 2.0
     *
     * @param array|Collection $config Configuration data
     *
     * @return self
     */
    public static function factory($config = array())
    {
        $default = array(
            'base_url' => 'https://api.box.com/2.0/',
        );
        $required = array('token');
        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('base_url'), $config);
        // Attach a service description to the client
        $description = ServiceDescription::factory(__DIR__ . '/service.json');
        $client->setDescription($description);

        $oauth_plugin = new Oauth2Plugin(array('Bearer ' . $config->get('token')));
        $client->addSubscriber($oauth_plugin);

        return $client;
    }
}
