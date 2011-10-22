<?php
 defined('SYSPATH') or die('No direct script access.');

 class Master_Admin extends Master_Master
  {
     public $template = 'templates/admin';
      
      // Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
      // Can be set to a string or an array, for example 'login' or array('login', 'admin')
      // Note that in second(array) example, user must have both 'login' AND 'admin' roles set in database
     public $auth_required =  array('login','admin');
     //public $auth_required = FALSE;
      // Controls access for separate actions
      // 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
      // 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
  	 public $secure_actions = FALSE;
     
     public $user_id=FALSE;
  
     /**
      * Initialize properties before running the controller methods (actions),
      * so they are available to our action.
      */
     public function before()
      {
         
      
         // Run anything that need ot run before this.
         parent::before();
          
	        // place session in cookie (appended by Swiff.Uploader - appendCookieData)
	        $this->session= isset($_POST['session']) ? Session::instance(NULL, $_POST['session']):Session::instance();
	        
	        
	        if ($user=$this->user=$this->account=Auth::instance()->get_user()) {
	         $this->user_id=$user->id;
	         $this->start_node=Auth::instance()->get_user()->start_node;
	        }
	        
	            
	        #Check user auth and role
	        $action_name = $this->request->action();
	        if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
	                || (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && 
	                Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE))
					  { 
				  $this->auth();
					
					//check subscription status
					if (!$this->request->is_initial()){
	         $this->auto_render=FALSE;
	         $this->internal=true;
	        } else {
	          $this->update_subscription_details();
				    $this->check_subscription();
	        }
					
					//this needs updating to reflect a full db-crud assess table     
					    
					  } 
				   
				   $this->id=$this->request->param('id');   	
           $this->template->content          = '';
             
					  
           //if($this->auto_render)
           // {
              // Initialize empty values
              $this->template->title            = '';
              $this->template->titlepart        = array();
              $this->template->slideshownumber   = '';
              $this->template->meta_keywords    = '';
              $this->template->meta_description = '';
              $this->template->meta_copywrite   = '';
              $this->template->page             = '';
              $this->template->flash            = '';
              $this->template->styles           = array();
              $this->template->scripts          = array();
              $this->template->breadcrumb_part  = array();
              $this->template->breadcrumb       ='';
              
              $this->template->breadcrumb_part[]=HTML::anchor($this->request->url(array('controller'=>'','action'=>'','id'=>'')), 'Home');
          //  }      
          
      }
      
      

     /**
      * Fill in default values for our properties before rendering the output.
      */
     public function after()
      {
         if($this->auto_render)
          {
             // Define defaults
             $styles                  = array( 
                                            'assets/css/admin.css' => 'screen',
                                        //    'assets/css/admin_print.css' => 'print', 
                                        //    'assets/css/admin_mobile.css' => 'handheld',                                                                                                   
                                          );
             $scripts                 = array(
                                          );
             

             // Add defaults to template variables.
             $this->template->styles  = array_merge($styles,$this->template->styles);
             $this->template->scripts = array_merge($scripts,$this->template->scripts);
             
            $this->template->page=join($this->request->param(),' ');
             
             if ($this->template->title== ''){
              $this->template->titlepart[]="Admin System";
              $this->template->title= join(array_reverse($this->template->titlepart),' - ');
             } 
             
             
             if ($this->template->breadcrumb== ''){
                $this->template->breadcrumb    = join($this->template->breadcrumb_part,' &raquo; ').' &raquo;';
             }
             
             $this->template->flash   		  = Hint::render(); 
           }
         parent::after();
      }

    public function auth(){
   //remember where we were trying to get to.
              Session::instance()->set("requested_url","/".$this->request->uri()); 
              //if we are logged in then we don't have high enough priveleges
              if (Auth::instance()->logged_in()){
                $this->request->redirect('admin/user/noaccess');
              }else{
                $this->request->redirect('admin/user/login');
              }
   }
   
   
  
  public function check_subscription(){ 
  // we don't need to nag people if they are in the payment section
  if ($this->request->controller()=="payment") return;
  //echo "Checking sub...";
  $user=ORM::factory('user',$this->user_id); 
  
  //if user->account doesn't exist there may be a problem with spreedly - will ignore error states
  if (!$user->account->id) return;
  
     if ($user->account->active){
       if ($user->account->type=="Trial"){
         //you are on trial and have xx days left
       } elseif(!$user->account->recurring) {
         //your account id due to expire in xx days
       }
       if ($user->account->card_expired) {
         //your cred it card is due to expire before the next payment is taken//update here
       }
       
       
       
     } else {
       Hint::set(Hint::ERROR,"Your subscription has expired!  Upgrade your account to one of our <a href='/admin/payment/plans/'>great packages</a>");
     }
     
   }
   
   
   public function success($item='record',$extra=null){
     Hint::set(Hint::SUCCESS,"Your $item was successfully updated.$extra");
   }
   public function failed($item='record',$extra=null){
     Hint::set(Hint::SUCCESS,"There was a problem updating your $item.$extra");
   }
   
   
 }
