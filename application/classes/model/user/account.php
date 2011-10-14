<?php defined('SYSPATH') or die('No direct script access.');
class Model_User_Account extends ORM
{
  protected $_table_name='account';
  protected $_belongs_to = array('user' => array());
  protected $_primary_key='id';
}

 