<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Gallery_User extends Master_Gallery {
	
	function action_index(){
	  return $this->action_login();
	}

  function action_login(){
    $status=false;
  
     $this->template->content= View::factory('pages/admin/login')
            ->bind('columns',$columns)
            ->bind('data',$_POST)
            ->bind('errors',$errors);
            
     $user=ORM::factory('user');
	   $fields = array('email','password');
	   $columns=Arr::extract($user->list_columns(),$fields);
	   
	   //try to login
	   if ($_POST&&$password=Arr::get($_POST,'password',false)){
	       Auth::instance()->login(Arr::get($_POST,'email'),$password);
	       if (!$status=Auth::instance()->logged_in()){
	         $errors['password']="The password you entered is incorrect";
	       }
	   } 
	   
	  if ($status && $url=Arr::get($_POST,'redirect',false)){
  	       $this->request->redirect($url);
     }
	   
	   //if this is internal
	  // if ($this->initial) {
	     //return $this->template->content=Hint::render().Form::render($columns,$_POST,$errors);
	  // }
	  
	  
	  //normal response
	   if ($status){
	      $destination=Session::instance()->get("requested_url",'/');
        $this->request->redirect($destination);
        return;
	   }
	 
	   
         
  }
  
  function action_quick(){
	   $this->template->content=View::factory('/pages/admin/edit')
	     ->bind('columns',$columns)
	     ->bind('data',$user)
	     ->bind('errors',$errors);
	       
	   $user=ORM::factory('user');
	   $fields = array('username','email');
	   $columns=Arr::extract($user->list_columns(),$fields);
	   
	   
	   //if we are signing up
	   if($_POST) {
	     $user=ORM::factory('user');
	     $password=Text::random();
  	   try {
  	     $name=Arr::get($_POST,'username');
  	     $extra=array();
  	     $extra['username']=URL::title($name,'_');
  	     $extra['password']=$password;
  	    //create user
  	     $user->create_user(Arr::merge($_POST,$extra),array('username','password','email'));
	     //upgrade user type
	       
	       //$user->set('password',$password);
	       $user->set('type','guest');
	       $user->set('name', $name );
	       $user->set('parent_id', $this->owner_id );
	       
	       $login=ORM::factory('role')->where('name','=','login')->find();
  	     $user->add('roles',$login->id);
  	     
  	     $user->save();
  	     
  	     Auth::instance()->login($user->username,$password);
  	     Mailer::factory('user')->send_welcome($data);
  	     Hint::set(Hint::SUCCESS,'You successfully created your account.');
  	     
  	     if ($url=Arr::get($_POST,'redirect',false)){
  	       $this->request->redirect($url);
  	     }
  	   
  	   } catch(ORM_Validation_Exception $e) {
	       $errors=$e->errors('models');
	       if (Arr::get($errors,'email',false)=='This email address is already registered to an existing account.'){
	         Hint::set(Hint::ERROR,'The email address you entered is already registered. Please enter your password or use a different email.');
	         return $this->template->content=Request::factory($this->request->url(array('action'=>'login')))->execute();
	       }
  	   }
	   } 
	   //if (!$this->request->initial()) {
	       return $this->template->content=Form::render($columns,$_POST,$errors);
	   //}
	   
  }
  
  function action_confirm(){
    $user=ORM::factory('user',Request::current()->param('id'));
    if(!$user->id) {$this->four0four();}
    
    if (arr::get($_GET,'unlock',false)==Encrypt::instance()->encode($user->password.$user->last_login)){
      $user->active=1;
      $user->save();
      Hint::set(Hint::SUCCESS,'Your account has now been confirmed');
      $destination=Arr::get($_GET,"return_url",'/');
      $this->request->redirect($destination); 
    }
  }
    	
}

?>


 