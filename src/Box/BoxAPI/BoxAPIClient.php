<?php

namespace Box\BoxAPI;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Box\Plugin\Oauth2\Oauth2Plugin;
use Zend\Mime\Part;
use Zend\Mime\Message;

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
        $default = array('redirect.disable' => true);
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
     * Get information about a folder's items.
     *
     * @param integer $id The folder ID.
     * @param integer $id The folder ID.
     * @param integer $id The folder ID.
     * @param integer $id The folder ID.
     * @return array|mixed
     */
    public function getFolderItems($id, $fields = NULL, $limit = 100, $offset = 0)
    {
        $command = $this->getCommand('GetFolderItems', array('id' => $id, 'fields' => $fields, 'limit' => $limit, 'offset' => $offset));
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
     * Updates a folder.
     *
     * @param string $id The ID of the folder to be deleted.
     * @param array $params Parameters to set on the new folder
     * @param string $etag Optional etag to send in if-match header.
     * @return array|mixed
     */
    public function updateFolder($id, $params = array(), $etag = NULL)
    {
        $params['id'] = $id;
        $params['if-match'] = $etag;
        $command = $this->getCommand('UpdateFolder', $params);
        return $this->execute($command);
    }

    /**
     * Get a folder's discussions.
     *
     * @param integer $id The folder ID.
     * @return array|mixed
     */
    public function getFolderDiscussions($id)
    {
        $command = $this->getCommand('GetFolderDiscussions', array('id' => $id));
        return $this->execute($command);
    }

    /**
     * Get a folder's collaborations.
     *
     * @param integer $id The folder ID.
     * @return array|mixed
     */
    public function getFolderCollaborations($id)
    {
        $command = $this->getCommand('GetFolderCollaborations', array('id' => $id));
        return $this->execute($command);
    }

    /**
     * Get a folder's collaborations.
     *
     * @return array|mixed
     */
    public function getTrashItems($fields = NULL, $limit = 100, $offset = 0)
    {
        $command = $this->getCommand('GetTrashItems', array('fields' => $fields, 'limit' => $limit, 'offset' => $offset));
        return $this->execute($command);
    }

    /**
     * Get a folder's discussions.
     *
     * @param integer $id The folder ID.
     * @return array|mixed
     */
    public function deleteTrashedFolder($id)
    {
        $command = $this->getCommand('DeleteTrashedFolder', array('id' => $id));
        return $this->execute($command);
    }

    // @TODO Restore trashed folder

    /**
     * Get a file's metadata.
     *
     * @param integer $id The file ID.
     * @return array|mixed
     */
    public function getFile($id, $fields = NULL)
    {
        $params['id'] = $id;
        if ($fields) {
            $params['fields'] = $fields;
        }
        $command = $this->getCommand('GetFile', $params);
        return $this->execute($command);
    }

    // @TODO Update file

    /**
     * Get a file's metadata.
     *
     * @param integer $id The file ID.
     * @return array|mixed
     */
    public function downloadFile($id, $version = NULL)
    {
        $command = $this->getCommand('DownloadFile', array('id' => $id, 'version' => $version));
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

    /**
     * Delete a file.
     *
     * @param integer $id The file ID.
     * @param string $etag Optional etag to send in if-match header.
     * @return array|mixed
     */
    public function deleteFile($id, $etag = NULL)
    {
        $params = array('id' => $id,  'if-match' => $etag);
        $command = $this->getCommand('DeleteFile', $params);
        return $this->execute($command);
    }

    /**
     * Used to retrieve the metadata about a shared item when only given a shared link.
     * Because of varying permission levels for shared links, a password may be required
     * to retrieve the shared item.
     *
     * @param string $shared_link The shared link for this item.
     * @param string $password The password for this shared link.
     * @return array|mixed
     */
    public function getSharedItem($shared_link, $password = NULL, $fields = NULL)
    {
        $params['shared_link'] = 'shared_link=' . $shared_link;
        if ($password) {
            $params['shared_link'] = '&shared_link_password=' . $password;
        }
        if ($fields) {
            $params['fields'] = $fields;
        }
        $command = $this->getCommand('GetSharedItem', $params);
        return $this->execute($command);
    }

    public function metaGetType($id, $type)
    {
      $command = $this->getCommand('MetaGetType', array('id' => $id, 'type' => $type));
      return $this->execute($command);
    }

    public function metaUpdateType($id, $type, $operations)
    {
        $command = $this->getCommand('MetaUpdateType', array('id' => $id, 'type' => $type, 'operations' => $operations));
        return $this->execute($command);
    }

}
