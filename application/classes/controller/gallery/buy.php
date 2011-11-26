<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_Buy extends Master_Gallery {
	
	public function before(){
    //if requested method doesn't exist use default
    //we do this as default actions are set based on albums settings and don't always exist
    //This also comes before the parent::before as the action is overridden by accound suspention and password protection
    if (!method_exists($this, "action_".$this->request->action())){
      $this->request->action('album');
    }
    parent::before();
  }
	
	
	function action_image(){
	  $item=$this->request->param('id');
	  if (!$item) {
	   return $this->template->content= '-no image specified-';
	  }
	  $this->template->content= 'buying image '.$item;
	  $this->add($item);
	  //show purchasae options
	  /*
Prints 
	    Size
	    Paper type
	  
	  Canvas
	    Size
	  
	  Poster
	    Size
	    
	  Quantity   
*/ 
	  
	  if ($_POST){
	  //  adding detials
	  }

	 //add one image to cart
	}
	
	function action_album(){
	  $item=$this->node;
	   $this->template->content= 'buying album '.$item->name;
	   foreach ($this->node->images->find_all() as $image){
	     $this->add($image->id);
	   }
	 //add whole album
	}
	
	function add($image_id){
	  //add to cart
	  $this->template->content.="<br />--adding image {$image_id}--";
	}
	
	function action_remove(){
	 //remove item
	}
	
	function action_checkout(){
	 // start check out process - Poss seperate func
	}
	
	function action_edit(){
	 // set quantities 
	}
}

?>


 