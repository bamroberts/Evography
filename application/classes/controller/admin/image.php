<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Image extends Master_Admin {
  var $model='image';
  
  function action_index() {
     if (!$this->request->param('id')) return $this->action_view();
     $this->template->content = View::factory('pages/admin/image-details')
        ->bind('image', $image);
     $image=ORM::factory('image',$this->request->param('id'));
  }
  
  function action_delete(){
  	$image=ORM::factory('image',$this->request->param('id'));
  	$image->delete();
  	if (!$this->request->is_ajax()) {
  	  $this->request->redirect(Arr::get($_GET,'return_path','/admin/images/'));
  }
  	
  }
  
  function action_rotate(){
   
    //left or right:
    $image=ORM::factory('image',$this->request->param('id'));
    $direction=Arr::get($this->request->query(),'direction',1);
    
    //Delete old images and create a new cache id
    $this->wipe_cache($image);
    $image->filehash=uniqid();
    
    // flip max dimentions
    $width=$image->width;
    $image->width=$image->height;
    $image->height=$width;
    
    //set rotate flag
    $image->rotate=$image->rotate+$direction;
    
    //save
    $image->save();
    
    $this->request->redirect($this->request->url(array('action'=>'')));
    
  }
  
  function action_crop(){
  
  $x_width=($img->width / $thumb_w); 
  $x_height=($img->height / $thumb_h);
  
  $image->crop=serialize(array(
   'top'=>round($top*$x_height)
  ,'height'=>round($height*$x_height)
  ,'left'=>round($height*$x_width)
  ,'width'=>round($height*$x_widt)
  ));
  
  
  }
  
  function wipe_cache($image_record=null){
    $image=($image_record)?$image_record:ORM::factory($this->request->param('id'))->filehash;
    if (!$image->filehash) return;
    File::destroy_directory("images/dynamic/".$image->filehash,true);
  }
  
  

}