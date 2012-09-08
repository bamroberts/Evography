<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Menu extends Master_Admin {

  function action_index(){
    $items = Orm::factory('menu',$this->request->param('id',1))->children;
    $this->content->template=$this->getView('blocks/menu')//View::factory('admin/block/menu')
      ->bind('items',$items);
    }
}