<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Gallery_Upload extends Controller_Gallery_Album_Master {
    
    function action_index(){
      if ( false && !$this->node->settings->upload) return;
      $this->template->content=View::factory('pages/admin/upload')
        ->bind('a',$a);
      
    } 

}