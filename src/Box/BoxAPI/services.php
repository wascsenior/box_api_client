<?php

return array(
  'name' => 'Box.com',
  'apiVersion' => '2.0',
//  'baseUrl' => 'https://api.box.com/2.0/',
  'description' => 'Box.com is a cloud file storage service',
  'operations' => array(
    'GetFolder' => array(
      'httpMethod' => 'GET',
      'uri' => 'https://api.box.com/2.0/folders/{id}',
      'parameters' => array(
        'id' => array(
          'location' => 'uri',
          'description' => 'Folder to retrieve by ID',
          'type' => 'string',
          'required' => true,
        ),
      ),
    ),
    'CreateFolder' => array(
      'httpMethod' => 'POST',
      'uri' => 'htt[s://api.box.com/2.0/folders',
      'parameters' => array(
        'name' => array(
          'location' => 'json',
          'type' => 'string',
          'required' => true,
        ),
        'parent' => array(
          'location' => 'json',
          'type' => 'object',
          'properties' => array(
            'id' => array(
              'location' => 'json',
              'type' => 'string',
              'required' => true,
            ),
          ),
        ),
      ),
    ),
    'UploadFile' => array(
      'httpMethod' => 'POST',
      'uri' => 'https://uploads.box.com/api/2.0/files/content',
      'parameters' => array(
        'filename' => array(
          'location' => 'postFile',
          'type' => 'string',
          'required' => true,
        ),
        'parent_id' => array(
          'location' => 'postField',
          'type' => 'string',
          'required' => true,
        ),
        'content_created_at' => array(
          'location' => 'postField',
          'type' => 'string'
        ),
        'content_modified_at' => array(
          'location' => 'postField',
          'type' => 'string'
        ),
      ),
    )
  ),
);
