<?php defined('SYSPATH') or die('No direct script access.');
class Model_user_facebook extends ORM
{
  protected $_table_name = 'facebook_user';
  protected $_model=array();
  protected $_belongs_to = array('user' => array());
}