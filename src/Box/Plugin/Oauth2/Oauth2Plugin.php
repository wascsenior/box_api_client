<?php

namespace Box\Plugin\Oauth2;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Http\Message\Request;
use Guzzle\Common\Event;

/**
 * Plugin to add the necessary Oauth 2 headers to a request.
 */
class Oauth2Plugin implements EventSubscriberInterface
{
    /**
     * @var array Auth headers to be added to the request.
     */
    private $auth_headers;

    /**
     * Construct a new Oauth2Plugin
     *
     * An array of auth headers to be added to the request.
     */
    public function __construct(array $auth_headers)
    {
        $this->auth_headers = $auth_headers;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend', 255),
        );
    }

    /**
     * Add cookies before a request is sent
     *
     * @param Event $event
     */
    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request'];
        if (!empty($this->auth_headers))
        {
            foreach ($this->auth_headers as $value) {
              $request->addHeader('Authorization', $value);
            }
        }
    }

}
