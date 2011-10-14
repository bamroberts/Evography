<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Guestbook extends Controller_Admin_Album_Core {

  protected $_fields=array('name', 'desc', 'published','facebook','private','theme');
  
  function action_index(){
    if (!$this->id) $this->fof();
    $collection=Orm::factory($this->_model,$this->id);
    //list these out in a table
    foreach ($collection->comment->find_all() as $key=>$comment){
      $this->template->content.="<p>$key:{$comment->message} ({$comment->user->name})</p>";
    }
  }
  function action_approve(){}
  function action_remove(){}
  
  public function action_upload(){
    return $this->fof();
  }
}