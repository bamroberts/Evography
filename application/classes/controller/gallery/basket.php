<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_Basket extends Master_Gallery {
	
	function before(){
	 parent::before();
	 
	 //and to normalise the default action

	 //this is to make sure that this controller can only be called at route level;
   if ($this->node->id!=$this->root->id) {
	   $this->request->redirect(Route::url($this->root->id, array('controller'=>'basket')));
	 }
	 
	 if (!method_exists($this, "action_".$this->request->action())){
      $this->request->action('index');
   }
	 
	}
	
	function action_index(){	
   $this->template->content="<h1>You are in the basket</h1>";	
	}
	
	function action_update(){
	  
   $this->template->content="<h1>Update the basket</h1>";	
	}
	
  function action_empty(){
	
   $this->template->content="<h1>Empty the basket</h1>";	
	}
	
	function action_remove(){}
	
	function action_add(){
	  if ($post=$this->request->initial()->post()){
	    //add to cart
	    
	  }
	}
}