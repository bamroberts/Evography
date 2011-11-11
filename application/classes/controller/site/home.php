<?php 
class Controller_Site_Home extends Master_Site {
  protected $private_beta=true;

	function action_index(){
		$this->template->content=View::factory('site/home');
		$this->request->action(false);
	}
	
	function action_tour(){
		$this->template->content=View::factory('site/tour');
	}
	
  function action_pricing(){
		$this->template->content=View::factory('site/pricing');
	}
	
  function action_unknown(){
    $this->response->status(404);
		$this->template->content=View::factory('site/unknown');
	}
	
	function action_features(){
		echo 'list of features will go here!';

	}
	
	function action_signup(){
	  /*
$this->template->styles=array( 
        'assets/css/960.css' => 'screen',
        'assets/css/admin_alecmaxwell.css' => 'screen',                                                                                                    
      )
      
      
*/;

    if ($this->private_beta){
      if ($code=$this->request->query('invite')){
        $invite=Orm::factory('invite',array('unlock'=>$code));
        if ($email=$invite->email) {
          return $this->create_account();
        }
        echo 'wrong invite: '.$invite;
      }
    } else {return $this->create_account();}
    
    return $this->register_interest();

	   	   
	   	}
	
	function email_welcome($user){
	Hint::set(Hint::SUCCESS,'An email with your account information in has been sent to your email address.');
	   //Email::send('welcome',$user);
	   return true;
	}
	
	function create_account(){//if we are signing up
	$this->template->content=View::factory('site/signup')
	     ->bind('columns',$columns)
	     ->bind('data',$user)
	     ->bind('errors',$errors);
	     
	   $user=ORM::factory('user');
	   $fields = array('username','email','password');
	   $columns=Arr::extract($user->list_columns(),$fields);
	
	   if($_POST) {
	     $user=ORM::factory('user');
	     //$user->values($_POST);
	     

  	   try {
  	    //create user
  	     $user->create_user($_POST,$fields);
	     //upgrade user type
	       $user->set('type','client');
  	     $user->save();
  	    //add permissions
  	     $login=ORM::factory('role')->where('name','=','login')->find();
  	     $user->add('roles',$login->id);
  	     $client=ORM::factory('role')->where('name','=','client')->find();
  	     $user->add('roles',$client->id);
  	    //create specific role for this account  
  	     $role=ORM::factory('role');
  	     $role->set('name','client_'.$user->id);
  	     $role->set('description','Role for client '.$user->username);
  	     $role->save();
  	    //add this role
  	     $user->add('roles',$role->id); 
  	    //log us in 
  	     Auth::instance()->login($user->username,Arr::get($_POST,'password'));
  	    //set success message 
  	     Hint::set(Hint::SUCCESS,'You successfully created your account.');
  	     
  	     $this->email_welcome($user);
  	     
  	    //redirect to admin area to continue setting up account.
  	     $this->request->redirect('admin/user/welcome');
  	   } catch(ORM_Validation_Exception $e) {
	       $errors=$e->errors('models');
  	     Hint::set(Hint::ERROR,'There was a problem.');
  	   }
	   
	   }
}
	
	function register_interest(){
	 $fields=array(
  	 'name'=>array(
  	   'driver'=>'input',
  	   'type'=>'text',
  	   'label'=>'Your name',
  	   'attr'=>array(
  	     'placeholder'=>'John Smith',
  	   ),
  	 ),
  	 'email'=>array(
  	   'driver'=>'input',
  	   'type'=>'email',
  	   'label'=>'Your email address',
  	   'attr'=>array(
  	     'placeholder'=>'me@some-domain.com',
  	   ),
  	 ),
  	 'submit'=>array(
  	   'driver'=>'submit',
  	   'label'=>'Keep me in the loop',
  	   'attr'=>array(
  	     'class'=>'btn primary',
  	   ),
  	 ),
   );
	
	
	 $this->template->content=View::factory('site/invite')
	   ->bind('form',$form);
	   
	   $form = Formo::Form(array('alias'=>'invite','attr'=>array('class'=>'form-stacked')));
	   foreach ($fields as $name=>$options){
	          // $options['value']=Arr::get($post,$name)
	           $form->add($name,$options);   
	   }
	 }
  
  function action_available(){
    
  }	
}
?>
