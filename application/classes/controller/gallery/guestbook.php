<?php defined('SYSPATH') or die('No direct script access.');
 
 class Controller_Gallery_Guestbook extends Controller_Gallery_Album_Master {


  public function action_post(){
    return $this->action_view();
  }
 }