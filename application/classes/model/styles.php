<?php defined('SYSPATH') or die('No direct script access.');
class Model_Styles extends ORM
{
  protected $_table_name='styles';
  protected $_has_many = array('album' => array());
  protected $_primary_key='id';


   
}
