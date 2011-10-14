<?php defined('SYSPATH') or die('No direct script access.');
 
 class Controller_Gallery_Guestalbum extends Controller_Gallery_Album_Master {
   
  public function action_upload(){
    $this->action_view();
    $album_id=$this->request->param('id');
    $this->template->content=Request::factory("admin/facebook/{$album_id}/import")->execute();
  }
  
 }