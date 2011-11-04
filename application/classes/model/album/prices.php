<?php defined('SYSPATH') or die('No direct script access.');

class Model_Album_Prices extends ORM {
    
    protected $_table_name='album_prices';
    protected $_primary_key='album_id';
    protected $_belongs_to=array(
      'album'=>array('model'=>'album','foreign_key'=>'album_id'),
      'image'=>array('model'=>'image','foreign_key'=>'image_id'),
    );   
}
  