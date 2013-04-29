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
        $default = array();
        $required = array('token');
        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('base_url'), $config);
        // Attach a service description to the client
        $description = ServiceDescription::factory(__DIR__ . '/services.php');
        $client->setDescription($description);

        $oauth_plugin = new Oauth2Plugin(array('Bearer ' . $config->get('token')));
        $client->addSubscriber($oauth_plugin);

        return $client;
    }

    /**
     * Get information about a folder.
     *
     * @param integer $id The folder ID.
     * @return array|mixed
     */
    public function getFolder($id)
    {
        $command = $this->getCommand('GetFolder', array('id' => $id));
        return $this->execute($command);
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
        $command = $this->getCommand('CreateFolder', array('parent' => array('id' => $parent_id), 'name' => $name));
        return $this->execute($command);
    }

    /**
     * Copy a folder.
     *
     * @param string $id The ID of the folder to be copied.
     * @param string $parent_id The ID of the destination's parent.
     * @param string $name Optional name of new folder.
     * @return array|mixed
     */
    public function copyFolder($id, $parent_id, $name = NULL)
    {
        $command = $this->getCommand('CopyFolder', array('id' => $id, 'parent' => array('id' => $parent_id), 'name' => $name));
        return $this->execute($command);
    }

    /**
     * Delete a folder.
     *
     * @param string $id The ID of the folder to be deleted.
     * @param boolean $recursive Whether or not to recursively delete files.
     * @param string $etag Optional etag to send in if-match header.
     * @return array|mixed
     */
    public function deleteFolder($id, $recursive = FALSE, $etag = NULL)
    {
        $params = array('id' => $id,  'if-match' => $etag);
        $params['recursive'] = $recursive ? 'true' : NULL;
        $command = $this->getCommand('DeleteFolder', $params);
        return $this->execute($command);
    }


    /**
     * Upload a file.
     *
     * @param string $file The path to the file to be uploaded.
     * @param string $parent_id The ID of the parent folder.
     * @return array|mixed
     */
    public function uploadFile($file, $parent_id)
    {
        $command = $this->getCommand('UploadFile', array('parent_id' => $parent_id, 'filename' => $file));
        return $this->execute($command);
    }

}
