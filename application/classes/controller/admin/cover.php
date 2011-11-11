<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Cover extends Controller_Admin_Upload {
  
  function action_index(){
    
    $original=$this->node->cover_image_id;
    
          $start_node=ORM::factory('album',$this->start_node);

    $this->template->content = View::factory('admin/collection/cover')
      ->set('inherit',$start_node->get_descendants(true))
      ->set('albums',$this->node->get_descendants(false))    
      ->bind('album_selected',$album_selected)
      ->bind('images',$images)
      ->set('current',$this->node);
      
    $post=$this->request->initial()->post(); 
    
    $images=array();
      
    if ($inherit=Arr::get($post,'inherit')) {
      //$album=ORM::factory('album',$inherit);
      $this->node->set('cover_image_id',$inherit)->save();
    }
    
    if($album_selected=Arr::get($post,'album')){
      $images=ORM::factory('album',$album_selected)->images->find_all();
      if($chosen=Arr::get($post,'image')){
       $image=ORM::factory('image',$chosen);
       $this->node->set('cover_image_id',$image->id)->save();
      }
    }
    
   // print_r($_FILES);
    if (count($_FILES) && $_FILES['file']['name']) {
      //upload and save
      //make orphan
      $image=$this->import(true);
      $image->set('album_id',false)->save();
      $this->node->set('cover_image_id',$image->id)->save();
    }
    
    if ($this->node->cover_image_id!=$original) {
        $this->request->redirect($this->request->initial()->url(array('action'=>false))); 
    }  
  }
}