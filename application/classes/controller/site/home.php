<?php 
class Controller_Site_Home extends Master_Site {
  protected $private_beta=true;
  protected $offline=false;

  function before(){
    parent::before();
    if ($this->offline && $this->request->query('unlock')!='lemoncurd') {
        $this->request->redirect(Route::URL('admin'));
    }
  }

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
    if ($this->private_beta){
      if ($code=$this->request->query('invite')){
        $invite=Orm::factory('invite',array('unlock'=>$code));
        if ($invite->email) {
          return $this->create_account($invite);
        }
        Hint::set(Hint::ERROR,'<b>Code not found.</b> Sorry, that invite code does not exist in our system.');

      }
    } else {return $this->create_account();}
    
    return $this->register_interest();

	   	   
	   	}
	
	function email_welcome($user){
	Hint::set(Hint::SUCCESS,'An email with your account information in has been sent to your email address.');
	   //Email::send('welcome',$user);
	   return true;
	}
	
	function create_account($invite=false){//if we are signing up
	$this->template->content=View::factory('site/signup')
	     ->bind('columns',$columns)
	     ->bind('data',$user)
	     ->bind('errors',$errors);
	     
	   $user=ORM::factory('user');
	   $fields = array('username','email','password');
	   $columns=Arr::extract($user->list_columns(),$fields);
	
	   if( $post=$this->request->post('user') ) {
	     $user=ORM::factory('user');
	  // try {
  	    //create user
  	     $user->set('type','client');
  	     $user->create_user($post,$fields);
  	    
  	    //create specific role for this account  
  	     $role=ORM::factory('role')
  	          ->set('name','client_'.$user->id)
  	          ->set('description',"Role for client {$user->username} ({$user->email})")
  	          ->save();
        //get general access permissions
  	     $login =ORM::factory( 'role', array('name'=>'login') );
  	     $admin =ORM::factory( 'role', array('name'=>'admin') );
  	     $client=ORM::factory( 'role', array('name'=>'client') );
  	     
  	    //add roles 
  	     $user->add('roles',$login->id)
  	          ->add('roles',$admin->id)
  	          ->add('roles',$client->id)
  	          ->add('roles',$role->id);
  	           
  	    //log us in 
  	     Auth::instance()->login($user->username,Arr::get($_POST,'password'));
  	     
  	     //create initial album
  	     $album = Orm::factory('album');
  	     $album->set('user_id',$user->id)
  	           ->set('name',ucwords($user->username)) 
  	           ->set('type','collection') 
  	           ->set('published',1);
  	     $album->save();
  	     
  	     $user->set('start_node',$album->id);
  	     
  	     //create default domain
  	     $domain=Orm::factory('domain');
  	     $domain->set('user_id',$user->id)
  	            ->set('name',"{$user->name}.evography.com")
  	            ->set('node_id',$album->id)
  	            ->set('system',1)
  	            //->set('theme',1)//?? issue
  	            ->set('published',1);
         $domain->save();
          	     
  	    //set success message 
  	     Hint::set(Hint::SUCCESS,'You successfully created your account.');
  	     if ($invite) 
  	     {
  	       $invite->delete();
  	     }
  	    //send welcome email 
  	     //$this->email_welcome($user);
  	   //  $recipt=email::factory('email/signup/welcome')
	     //          ->bind('details',$user)
	     //          ->to($user->email,$user->username)
	     //          ->subject('Welcome to '.SITENAME);
	     //          ->send();  	    
	               
	       //redirect to admin area to continue setting up account.
  	     $this->request->redirect('admin/user/welcome');
  	//   } catch(ORM_Validation_Exception $e) {
	  //     $errors=$e->errors('models/user');
  	//     Hint::set(Hint::ERROR,'Please correct your details.');
  	//   }
	   
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
	   
	   $form = Formo::Form(array('alias'=>'invite','form_message'=>'','attr'=>array('class'=>'form-stacked')));
	   foreach ($fields as $name=>$options){
	          // $options['value']=Arr::get($post,$name)
	           $form->add($name,$options);   
	   }
	   
	   if ($post=$this->request->post('invite')){
	     $invite=Orm::factory('invite')
	             ->values($post);
	             
	     try 
	     {
	       $invite->save();
	       $invite->clear();
	       Hint::set(Hint::INFO,"<b>Thanks!</b> Your interest has been registered. Well keep you updated.");
	       /*
         $recipt=email::factory('email/signup/interest')
	               ->bind('details',$invite)
	               ->to($invite->email,$invite->name)
	               ->subject('Thanks for registering your interest')
	               ->send();
	       $recipt=email::factory('email/system/interest')
	               ->bind('details',$invite)
	               ->to(Kohana::email,'System')
	               ->subject('New interest registered')
	               ->send();
      */
	       
	     }
       catch(ORM_Validation_Exception $e) {
  	       $errors=$e->errors('models');
  	       foreach ($errors as $field=>$error){
  	         $form->error($field,$error);
  	       }  
  	   }
  	   
  	   //load values into form from model.
	     $form->load(array('invite'=>$invite->as_array()));
	   }  
	 }
  

  
  
  
    
}
?>
