<?php defined('SYSPATH') or die('No direct script access.');
class Model_Collection extends ORM
{
  
  protected $_has_many = array(
	'albums' => array(
		'model' => 'album',
		'through'=> 'collection_albums',
	),
	'children' => array(
		'model' => 'collection',
		'foreign_key'=>'parent_id',
	),
  );
	
  protected $_belongs_to = array(
    'parent' => array(
        'model'       => 'collection',
        'foreign_key' => 'parent_id',
    ),
    'owner' => array(
        'model'       => 'user',
        'foreign_key' => 'user_id',
    ),
    
    'cover' => array(
        'model'       => 'image',
        'foreign_key' => 'cover_image_id',
    ),

  );

}