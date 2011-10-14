<?php defined('SYSPATH') or die('No direct script access.');

class Model_Album_Password extends ORM {
    
    protected $_table_name='album_password';
    protected $_primary_key='id';
    protected $_belongs_to=array(
      'album'=>array('model'=>'album','foreign_key'=>'id'),
    );   
}
  