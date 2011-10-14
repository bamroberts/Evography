<?php defined('SYSPATH') or die('No direct script access.');
class Model_User_option extends ORM
{
  protected $_model=array();
  protected $_belongs_to = array('user' => array());
  //protected $_primary_key='id';
}