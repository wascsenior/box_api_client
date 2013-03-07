<?php

namespace Box;

use Box\BoxAPI\BoxAPIClient;

class BoxAPI {

    /**
     * @var BoxAPICLient The client to use for requests.
     */
    private $client;

    /**
     * @param BoxAPI\BoxAPIClient $client
     *
     * @return self
     */
    public function __construct(BoxAPIClient $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get information about a folder.
     *
     * @param integer $id The folder ID.
     * @return array|mixed
     */
    public function getFolder($id)
    {
        $command = $this->client->getCommand('GetFolder', array('id' => $id));
        return $this->client->execute($command);
    }

    /**
     * Create a new folder.
     *
     * @param string $name The folder name
     * @param string $parent_id The parent folder's ID.
     * @return array|mixed
     */
    public function createFolder($name, $parent_id)
    {
        $command = $this->client->getCommand('CreateFolder', array('parent' => array('id' => $parent_id), 'name' => $name));
        return $this->client->execute($command);
    }
}
