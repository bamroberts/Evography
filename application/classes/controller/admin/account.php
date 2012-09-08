<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Account extends Master_Admin {

  function action_index(){}
  
  function action_edit(){
    $this->request->action('user');
    
    $this->request->param('subaction','edit');
    $this->sub();
  }
  
  function action_payment(){
    $this->sub();
  }
  function action_domains(){
    $this->sub();
  }
  function action_user(){
    $this->sub();
  }
  
  function after(){
  
    if ($this->auto_render) {  
      $view=$this->getView('account')
         ->set('content',$this->template->content)
         ;
      $this->template->content = $view;
    }
    
    parent::after();
  }


}