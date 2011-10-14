<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_Comments extends Controller_Gallery_Album_Master {
	
	function action_index(){
	}
	
	function action_album(){
	  $album=ORM::factory('album',$this->request->param('node'));
	  if (!$album->id){$this->h404();}
	  
	  $pagination = Pagination::factory(array(
        'total_items'    => $album->comment->where('approved','=',1)->count_all(),
        'items_per_page' => Arr::get($_REQUEST['current'],'limit',5),
        'current_page'   => array('source' => 'query_string', 'key' => 'comments'),
        ));
		        
    $comments=$album
        		 ->comment
        		 ->where('approved','=',1)
        		 ->limit($pagination->items_per_page)
        		 ->offset($pagination->offset)
        		 ->order_by('add_date','DESC')
        		 ->find_all();
        		 
	  
	  
	  $this->template->content=Theme::factory(array("{$this->theme}/comments",'default/comments'))
	     ->bind('comments',$comments)
	     ->bind('pagination',$pagination)
	     ;
	  

	  
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
	
	function action_draw(){
	  $this->template->content=Theme::factory(array("{$this->theme}/blocks/form",'default/blocks/form'))
	     ->bind('columns',$columns)
	     ->bind('data',$data)
	     ->bind('errors',$errors)
	     ->bind('inject',$user)
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


 