<?php defined('SYSPATH') or die('No direct script access.');
class Model_Theme extends ORM
{
  //protected $_belongs_to = array('user' => array());
  
    public function find_mine(){
       return $this->where('user_id','=',Auth::instance()->get_user()->id)
               ->or_where('user_id','=',null)
               ->find_all();
  } 
  
}