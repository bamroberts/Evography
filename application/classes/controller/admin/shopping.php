<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Shopping extends Controller_Admin_Album_core {
  
  function action_index(){
    $album=$this->node;
    $prices=$album->prices;
    
    $data=array();
    foreach ($prices as $price) {
      if (! Arr::get($data,$price->category)) 
      {
        $data[$price->category]=array();
      }
      $data[$price->category][]=$price;  
      }
    $this->template->content = View::factory('admin/album/shopping')
    ->bind('album',$album)
    ->bind('prices',$data);
  }
  
  function action_add(){
    echo "got it goood!!";
  }
  
}