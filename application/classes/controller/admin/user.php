<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Master_Admin {
	
	public $auth_required = FALSE;
	public $secure_actions     = array('index' => array('login'),'welcome' => array('login'),'options' => array('login'),'details' => array('login'));

  function action_index(){
      
      $this->template->content = $this->getView('home')//View::factory('pages/admin/home')
          ->bind('actions',$actions)          
          ->bind('collections',$collections)
      ;
      
      $collections=Request::factory($this->request->url(array('controller'=>'collection')))->execute();
      $this->request->controller(false);  
  }	
  
  function action_welcome() {
      $this->template->content = $this->getView('welcome')//View::factory('pages/admin/welcome')
            ->bind('step',$step)
            ->bind('content',$content);            //Get step
      
      if(!ORM::factory('user_option',$this->user_id)->user_id){
        //set up user options
        $step=1;
        $content=Request::factory('admin/user/options')->execute();
      } elseif (!ORM::factory('album')->where('user_id','=',$this->user_id)->count_all()){
        //create an album
        $step=2;
        $content=Request::factory('admin/album/add')->execute();
      } elseif (!ORM::factory('album')->where('user_id','=',$this->user_id)->find()->images->count_all()) {
        //upload some pictures
        $step=3;
        $id=ORM::factory('album')->where('user_id','=',$this->user_id)->find()->id;
        $content=Request::factory('admin/album/'.$id.'/upload')->execute();
      } else {
        //goto album
        $step=4;
        $content='Go to check out <a href="'.URL::Site(Route::get('user')->uri(array('user'=>Auth::instance()->get_user()->username))).'">your gallery<a>';
      }
      
      //switch (ste)
  
  
  }	
	
  public function action_login()
  {
    #If user already signed-in
    if(Auth::instance()->logged_in()!= 0){
      #redirect to the user account
      $this->request->redirect('admin');   
    }
    
    $user = ORM::factory('user');
    $user->values($_GET, array('username'));    
    $user->values($_POST, array('username', 'password','remember_me'));    
    $columns=Arr::extract($user->list_columns(),array('username','password','remember_me'));
    
    $content = $this->template->content = $this->getView('login')//View::factory('pages/admin/login')
            ->bind('columns',$columns)
            ->bind('data',$user)
            ->bind('errors',$errors);      
    //If there is a post and $_POST is not empty
    if ($_POST)
    {
      $username=Arr::get($_POST,'username');
    //alows us to login using either username or email.
    //If supplied input is a valid email look up username.
      $rules=array(
        'email' => array(
				    array('email'),
			   ),
			);
			$email=Validation::factory($rules);
			if ($email->check()){
			  $user=Orm::factory('user')->where('email','=',$username)->find();
			  if ($user->username) $username=$user->username;
			}
      
      #Check Auth
      Auth::instance()->login($username, Arr::get($_POST,'password'),Arr::get($_POST,'remember_me'));
      $status = Auth::instance()->logged_in();
 
      #If the post data validates using the rules setup in the user model
      if ($status)
      {   
        #redirect to the original requested page or user account
        $destination=Session::instance()->get("requested_url",'admin');
        $this->request->redirect($destination);
      }else{
     	$user_exists=$user->where('username','=',$username)->count_all();
      if (!$user_exists) {	
     	$errors['username']="Username not found";
     	} else { 
        $errors['password']= "Incorrect password.";
    	}
        #Get errors for display in view
        $content->errors = $errors;
      }
    }
  }
 
  public function action_options(){
      $this->template->content = $this->getView('edit')//View::factory('pages/admin/edit')
     	  ->bind('columns',$columns)
        ->bind('data', $data)
        ->bind('errors', $errors);
      
      $user=Orm::factory('user',$this->user_id);
      $data=$user->options;
      $columns = $data->list_columns(); 
      //$columns = Arr::extract($data->list_columns(),$this->_fields);  
  }
  
    public function action_details(){
      $this->template->content = $this->getView('user-details')//View::factory('admin/user-details')
     	  ->bind('columns',$columns)
        ->bind('data', $data)
        ->bind('errors', $errors)
        ->bind('details', $details);
      
      $user=Orm::factory('user',$this->user_id);
      $user_fields=Arr::extract($user->list_columns(),array('email','name','password'));
      
      $details=$user->details;
      $details_fields=Arr::extract($details->list_columns(),array('nick','company','address'));
  
      $data    = Arr::merge($user->as_array(),$details->as_array());  
      $columns = Arr::merge($user_fields,$details_fields);  
      
      $columns['old_password']=$columns['password'];
      $columns['old_password']['name']="Please enter your current password";
      $columns['password']['name']="Please enter your new password";

      if ($post=$this->request->post()){
        //Data submisssion
        if ($new_password=Arr::get($post,'password')){
          //can probably do this as single validation?
          if ($user->password==Auth::instance()->hash(Arr::get($post,'old_password'))){
            try{
              $user->set('password',$new_password)->save();
            } catch (exception $e) {
              $errors=$e['models'];
            }
          } else {
            $errors['old_password']="Current password does not match";
          }
        }
        
        
        try{
          $user->values($post,array('email','name'))->save();
          $details->values($post,array('nick','company','address'))->save();
          $this->success();
        } catch (exception $e){
          $errors=$e['models'];
          $this->failed();
        }
      }
  }
  

 
  public function action_logout()
  {
    #Sign out the user
    Auth::instance()->logout();
 
    #redirect to the user account and then the signin page if logout worked as expected
    $this->request->redirect('admin/');   
  }
  
  public function action_noaccess(){
 	  $this->template->content= "You do not have access for this page! <pre>".print_r(Auth::instance()->get_user(),true)."</pre>";
 } 
 
 

 
}