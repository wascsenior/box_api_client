<?php

return array(
  'name' => 'Box.com',
  'apiVersion' => '2.0',
//  'baseUrl' => 'https://api.box.com/2.0/',
  'description' => 'Box.com is a cloud file storage service',
  'operations' => array(
    'GetFolderItems' => array(
      'description' => 'Retrieves the files and/or folders contained within this folder without any other metadata about the folder.',
      'httpMethod' => 'GET',
      'uri' => 'https://api.box.com/2.0/folders/{id}/items',
      'parameters' => array(
        'id' => array(
          'description' => 'The ID of the folder to be retrieved',
          'location' => 'uri',
          'type' => 'string',
          'required' => true,
        ),
        'fields' => array(
          'description' => 'Attribute(s) to include in the response',
          'location' => 'query',
          'type' => 'string',
        ),
        'limit' => array(
          'description' => 'The number of items to return',
          'location' => 'query',
          'type' => 'integer',
        ),
        'offset' => array(
          'description' => 'The item at which to begin the response',
          'location' => 'query',
          'type' => 'integer',
        ),
      ),
    ),
    'CreateFolder' => array(
      'description' => 'Used to create a new empty folder. The new folder will be created inside of the specified parent folder.',
      'httpMethod' => 'POST',
      'uri' => 'https://api.box.com/2.0/folders',
      'parameters' => array(
        'name' => array(
          'description' => 'The desired name for the folder',
          'location' => 'json',
          'type' => 'string',
          'required' => true,
        ),
        'parent' => array(
          'description' => 'The parent folder',
          'location' => 'json',
          'type' => 'object',
          'properties' => array(
            'id' => array(
              'description' => 'The ID of the parent folder',
              'location' => 'json',
              'type' => 'string',
              'required' => true,
            ),
          ),
        ),
      ),
    ),
    'GetFolder' => array(
      'description' => 'Retrieves the full metadata about a folder, including information about when it was last updated as well as the files and folders contained in it.',
      'httpMethod' => 'GET',
      'uri' => 'https://api.box.com/2.0/folders/{id}',
      'parameters' => array(
        'id' => array(
          'description' => 'The ID of the folder to be retrieved',
          'location' => 'uri',
          'type' => 'string',
          'required' => true,
        ),
      ),
    ),
    'CopyFolder' => array(
      'description' => 'Used to create a copy of a folder in another folder. The original version of the folder will not be altered.',
      'httpMethod' => 'POST',
      'uri' => 'https://api.box.com/2.0/folders/{id}/copy',
      'parameters' => array(
        'id' => array(
          'description' => 'The ID of the folder to be copied',
          'location' => 'uri',
          'type' => 'string',
          'required' => true,
        ),
        'name' => array(
          'description' => 'An optional new name for the folder',
          'location' => 'json',
          'type' => 'string',
        ),
        'parent' => array(
          'description' => 'Object representing the new location of the folder',
          'location' => 'json',
          'type' => 'object',
          'properties' => array(
            'id' => array(
              'description' => 'The ID of the destination folder',
              'location' => 'json',
              'type' => 'string',
              'required' => true,
            ),
          ),
        ),
      ),
    ),
    'DeleteFolder' => array(
      'description' => 'Used to delete a folder.',
      'httpMethod' => 'DELETE',
      'uri' => 'https://api.box.com/2.0/folders/{id}',
      'parameters' => array(
        'id' => array(
          'description' => 'The ID of the folder to be deleted',
          'location' => 'uri',
          'type' => 'string',
          'required' => true,
        ),
        'if-match' => array(
          'description' => 'This is in the ÔetagÕ field of the folder object.',
          'location' => 'header',
          'type' => 'string',
          'sentAs' => 'If-Match'
        ),
        'recursive' => array(
          'description' => 'Whether to delete this folder if it has items inside of it',
          'location' => 'query',
          'type' => 'string',
        ),
      ),
    ),
    'UpdateFolder' => array(
      'description' => 'Used to update information about the folder.',
      'httpMethod' => 'PUT',
      'uri' => 'https://api.box.com/2.0/folders/{id}',
      'parameters' => array(
        'id' => array(
          'description' => 'The ID of the folder to be updated',
          'location' => 'uri',
          'type' => 'string',
          'required' => true,
        ),
        'if-match' => array(
          'description' => 'This is in the ÔetagÕ field of the folder object.',
          'location' => 'header',
          'type' => 'string',
          'sentAs' => 'If-Match'
        ),
        'name' => array(
          'description' => 'The name of the folder',
          'location' => 'json',
          'type' => 'string',
        ),
        'description' => array(
          'description' => 'The description of the folder',
          'location' => 'json',
          'type' => 'string',
        ),
        'parent' => array(
          'description' => 'The parent folder',
          'location' => 'json',
          'type' => 'object',
          'properties' => array(
            'id' => array(
              'description' => 'The ID of the parent folder',
              'location' => 'json',
              'type' => 'string',
            ),
          ),
        ),
        'shared_link' => array(
          'description' => 'An object representing this itemÕs shared link and associated permissions',
          'location' => 'json',
          'type' => 'object',
          'properties' => array(
            'access' => array(
              'description' => "The level of access required for this shared link. Can be 'open', 'company', 'collaborators'",
              'location' => 'json',
              'type' => 'string',
            ),
            'unshared_at' => array(
              'description' => 'The day that this link should be disabled at. Timestamps are rounded off to the given day.',
              'location' => 'json',
              'type' => 'string',
            ),
            'permissions' => array(
              'description' => 'The set of permissions that apply to this link',
              'location' => 'json',
              'type' => 'object',
              'properties' => array(
                'download' => array(
                  'description' => 'Whether this link allows downloads',
                  'location' => 'json',
                  'type' => 'boolean'
                ),
                'preview' => array(
                  'description' => 'Whether this link allows previews',
                  'location' => 'json',
                  'type' => 'boolean'
                ),
              ),
            ),
          ),
        ),
        'folder_upload_email' => array(
          'description' => 'The email-to-upload address for this folder',
          'location' => 'json',
          'type' => 'object',
          'properties' => array(
            'access' => array(
              'description' => "Can be 'open' or 'collaborators'",
              'location' => 'json',
              'type' => 'string',
            ),
          ),
        ),
        'owned_by' => array(
          'description' => 'The user who owns the folder.',
          'location' => 'json',
          'type' => 'object',
          'properties' => array(
            'id' => array(
              'description' => 'The ID of the user, should be your own user ID.',
              'location' => 'json',
              'type' => 'string',
            ),
          ),
        ),
      ),
    ),
    'GetFolderDiscussions' => array(
      'description' => 'Retrieves the discussions on a particular folder, if any exist.',
      'httpMethod' => 'GET',
      'uri' => 'https://api.box.com/2.0/folders/{id}/discussions',
      'parameters' => array(
        'id' => array(
          'description' => 'The ID of the folder to be retrieved',
          'location' => 'uri',
          'type' => 'string',
          'required' => true,
        ),
      ),
    ),
    'GetFolderCollaborations' => array(
      'description' => 'Use this to get a list of all the collaborations on a folder i.e. all of the users that have access to that folder.',
      'httpMethod' => 'GET',
      'uri' => 'https://api.box.com/2.0/folders/{id}/collaborations',
      'parameters' => array(
        'id' => array(
          'description' => 'The ID of the folder to be retrieved',
          'location' => 'uri',
          'type' => 'string',
          'required' => true,
        ),
      ),
    ),
    'UploadFile' => array(
      'description' => 'Use the Uploads API to allow users to add a new file.',
      'httpMethod' => 'POST',
      'uri' => 'https://uploads.box.com/api/2.0/files/content',
      'parameters' => array(
        'filename' => array(
          'description' => 'The name of the file to be uploaded',
          'location' => 'postFile',
          'type' => 'any',
          'required' => true,
        ),
        'parent_id' => array(
          'description' => 'The ID of folder where this file should be uploaded',
          'location' => 'postField',
          'type' => 'string',
          'required' => true,
        ),
        'content_created_at' => array(
          'description' => 'The time this file was created on the userÕs machine.',
          'location' => 'postField',
          'type' => 'string'
        ),
        'content_modified_at' => array(
          'description' => 'The time this file was last modified on the userÕs machine.',
          'location' => 'postField',
          'type' => 'string'
        ),
      ),
    ),
  ),
);
