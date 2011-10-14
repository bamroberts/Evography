<?php defined('SYSPATH') or die('No direct script access.');
set_time_limit(600);
class Controller_Admin_Telepathy extends Master_Admin {

public $auth_required = FALSE;
//public $secure_actions     = array('export' => array('login'));

protected $_model = array(
   'fb_message'=>array(
       'name'=>'Message',
       'formtype'=>"textarea",
    
   ),
   'fb_post_feed'=>array(
      'formtype'=>'checkbox',
   ),
              
);

  public function before(){
    parent::before();
    if($this->request->is_initial()) {
   //   throw new HTTP_Exception_404('File not found!');
    }
  }
  
  public function action_index(){
    //draw input
  }
  
  

  public function action_comment(){
   $fb=$this->connect();
   $facebook=$fb->link;
   if (!$facebook) return;
   
   $this->template->content = Theme::factory('default/blocks/comment-facebook')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors)
      ->bind('user', $fb->user)
      ->bind('logoutUrl', $fb->logoutUrl)
      ->bind('loginUrl', $fb->loginUrl);
      
   if (!$fb->user) return;  
    //Only continue if we are logged in with facebook.   
  
  
 $default=array('fb_post_feed'=>1,'fb_type'=>true?'album':$this->request->initial()->controller(),'source'=>'facebook','add_date'=>date('Y-m-d H:i:s',time()))  ;
   $data=Arr::merge($default,$_POST);

   $fields = array('fb_message','fb_post_feed','fb_type','source','add_date');
   $columns=Arr::extract($this->_model,$fields);
 

     
   if ($_POST  && Arr::get($_POST,'source',false)=='facebook') {     
  
     
    
 $comment=ORM::factory('comment');
     $comment
      ->set('user_id',$this->user_id)
      ->set(Arr::get($_POST,'fb_type').'_id',$this->request->param('id'))
      ->set('message',Arr::get($_POST,'fb_message'))
      ->set('source',Arr::get($_POST,'source'))
      ->set('add_date',Arr::get($_POST,'add_date'));
    /* 
    // echo $message->add_date; die();
     
     try{
      $comment->check();
     } catch(ORM_Validation_Exception $e) {
	       $errors=$e->errors('models');
       return;
     }
     
     if (Arr::get($_POST,'fb_type','album')=='album'){
       $id=$comment->id;
     } else {
       $id=$comment->image->album->id;
     }
     
     //check to see if commenting is on
     $auth=$comment->album->comments;
     switch($auth){
      case 2:
        $comment->approved=1;
      case 1:
        $comment->save();
        //send email
       break;
     }
*/
     
      if (Arr::get($_POST,'fb_post_feed',false)){
        $data = array(
           'message' => "{$comment->message}",
           //'link' => URL::site($this->request->initial()->url(array('action'=>'')),'http'),
           'cb'=>''
           );
        $upload_comment = $facebook->api('/me/feed', 'post', $data);
      }
      
      $this->request->redirect($this->request->initial()->url(array('action'=>'')));
   }
  }
  
  public function connect(){
   require_once 'application/classes/facebook/facebook.php';

    // Create our Application instance.
    $facebook = new Facebook(array( //Telepathy
      'appId' => '111594835602224',
      'secret' => 'fc57c196af7196cb38d1d289a5cf9821',
      'cookie' => true,
      
      ));
      
    $data['link']=$facebook ;  
      
    //if ($code=Arr::get($_GET,'code',false)) $facebook->setAccessToken($code);    
         //Facebook Authentication part
    $data['user']       = $facebook->getUser();
    // We may or may not have this data based 
    
    $data['loginUrl']   = $facebook->getLoginUrl(
            array(
                'scope'         => 'email,user_photos,publish_stream',
            )
    );
    
    $data['logoutUrl']  = $facebook->getLogoutUrl();
    
    if ($data['user']) {
     //we are connected to FB and have accessed user details 
    
      
        try{
           $user_profile =  $facebook->api('/me?fields=id,picture,updated_time,link,name,email');
           } catch(FacebookApiException $e){
             //access has expired
             $data['user']=false;
             return (object) $data;
           }
           //if not logged in, auto create an account
           
    } else {
        $facebook_user=false;
       // $facebook=false;
        //echo "Connect with FB to use this feature!";
        return (object) $data;
    }
   $data['user']=ORM::factory('user',1)->facebook;
   
    
   return (object) $data;//$facebook;
  }

}
       
 ?>
