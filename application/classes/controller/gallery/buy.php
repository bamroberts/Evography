<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_Buy extends Master_Gallery {
	
	function action_index(){
	
	}
	
	function action_image(){
	  $item=$this->request->param('id');
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


 