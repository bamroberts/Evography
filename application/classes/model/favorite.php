<?php defined('SYSPATH') or die('No direct script access.');
class Model_favorite extends ORM
{
protected $_table_name = 'favorite';
protected $_belongs_to = array('image' => array(
        'foreign_key' => 'image_id',));
}