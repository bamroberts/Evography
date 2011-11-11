<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_Comments extends Controller_Gallery_Album_Master {
	
  public function before(){
    //if requested method doesn't exist use default
    //we do this as default actions are set based on albums settings and don't always exist
    //This also comes before the parent::before as the action is overridden by accound suspention and password protection
    if (!method_exists($this, "action_".$this->request->action())){
      $this->request->action('index');
    }
    parent::before();
  }
  
  function action_index(){
    if ($this->request->param('id')) return $this->action_image();
    
    return $this->action_album();
  }
  

  
	
	function action_album(){
	  $this->request->action('album');

	  $node=$this->node;
//	  if (!$album->id){$this->h404();}
	  
	     
        		 
	     $this->render($node);
	  	  

	  
	  if($_POST && $user_id=Auth::instance()->get_user()){
	  
	    $_POST['user_id'] = $user_id;     
	    $_POST['album_id']= $album->id;
	    $_POST['source']  = 'gallery';
	    
	    $_POST['approved']  = 1;
	    $_POST['add_date']= date('Y-m-d H:i:s',time());
	    $_POST['message'] = Text::auto_p($_POST['message']); 
	    $comment=ORM::factory('comment');
      $comment->values($_POST);
      $comment->save();	
      unset($_REQUEST);
      $this->request->redirect($this->request->initial()->url(array('action'=>'')));
	    
	  }    
	}
	
	function action_image(){ 
	  $this->request->action('image');
	  $node=Orm::factory('image',$this->request->param('id'));
	  $this->render($node);
	}
	

	
	function render($node){
	   $pagination = Pagination::factory(array(
        'total_items'    => $node->comment->where('approved','=',1)->count_all(),
        'items_per_page' => Arr::get($_REQUEST['current'],'limit',5),
        'item_type'      => 'comment'
       // 'current_page'   => array('source' => 'query_string', 'key' => 'comment-page'),
        ));
		        
    $comments=$node
        		 ->comment
        		 ->where('approved','=',1)
        		 ->limit($pagination->items_per_page)
        		 ->offset($pagination->offset)
        		 ->order_by('add_date','DESC')
        		 ->find_all();
	
	  $comment_block=Theme::factory(array("{$this->theme}/blocks/comments",'default/blocks/comments'))
	     ->bind('comments',$comments)
	     .$this->draw_form();
	     ;
    
    if ( $this->request->is_initial() ){
      $control=$pagination->render();
    }
    $details=$pagination->details();
	  
	  $this->template->content=Theme::factory(array("{$this->theme}/comments",'default/comments'))
	     ->bind('media',$comment_block)
	     ->bind('page_control',$control)
	     ->bind('page_details',$details)
	     //.$this->action_draw()
	     ;

	}
	
	function action_view(){
	 //remove item
	}
	
	function action_delete(){
	 // start check out process - Poss seperate func
	}
	
	function action_edit(){
	 // set quantities 
	}
	
		
	function action_add(){
	 $this->template->content= $this->request->param('id')?'Add to image':'Add to album';
	}
	
	
	function action_form(){
	 $this->template->content = $this->draw_form();
	}
	
	function draw_form(){
	   $form=Formo::form()
	   ->add('name','input',array('type'=>'text','label'=>'Your name'))
	   ->add('message','textarea',array('label'=>'Your message'))
	   ;
	
	  return Theme::factory(array("{$this->theme}/blocks/comments/form",'default/blocks/comments/form'))
	     //->bind('columns',$columns)
	     //->bind('data',$data)
	    // ->bind('errors',$errors)
	    // ->bind('inject',$user)
	     ->bind('form',$form)
	     ->set('submit',"Sign the guestbook")
	   ;

	 $columns=ORM::factory('comment')->list_columns(array('message'));
	 $data=$_REQUEST;
	 
	 
	 
	 
	 $user=ORM::factory('user',Auth::instance()->get_user());  
	  if ($user->id) {
	    $user="<p>You are logged in as {$user->username}</p>";
	  } else {
	    $user=Request::factory($this->request->url(array('controller'=>'user','action'=>'quick')))->execute();
	  }
	  //$this->template->content=$user.Form::render($columns,$data);
}	
	
}

?>


 