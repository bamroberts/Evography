<?php defined('SYSPATH') or die('No direct script access.');
set_time_limit(600);
class Controller_Admin_Facebook extends Master_Admin {

public $auth_required = FALSE;
//public $secure_actions     = array('export' => array('login'));

protected $_model = array(
  'album'=>array(  
      'name'=>'Select a FB album',
      'formtype'=>'select',
      'options'=>array(),
    ), 
  'all'=>array(
      'name'=>'All images',
      'formtype'=>'all',
      'from'=>'images',
    ), 
  'images'=>array(  
      'name'=>'Pick images',
      'formtype'=>'image_select',
      'options'=>array(),
    ),
   'fb_message'=>array(
       'name'=>'Message',
       'formtype'=>"textarea",
   ),
   'fb_post_feed'=>array(
       'name'=>'Publish',
       'formtype'=>"checkbox",
       'helper'=>"post a copy to my facebook feed?"
   ),
   'fb_type'=>array(
       'formtype'=>"hidden",
   ),
   'source'=>array(
       'formtype'=>"hidden",
   ),
   'add_date'=>array(
       'formtype'=>"hidden",
   ),                     
);

  public function before(){
    parent::before();
    if($this->request->is_initial()) {
   //   throw new HTTP_Exception_404('File not found!');
    }
  }

public function action_export(){
   if ($this->request->param('id')<1) {throw exception;}

    $fb=$this->connect();
    $facebook=$fb->link; 
    if (!$facebook) return;
    
    $columns=$this->_model;
    $data = Arr::extract($_POST, array('images'),false);
    
    
    $this->template->content = View::factory('pages/admin/facebook-export')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors)
      ->bind('user', $fb->user)
      ->bind('logoutUrl', $fb->logoutUrl)
      ->bind('loginUrl', $fb->loginUrl);
    echo CURLOPT_TIMEOUT;
          
    $album = ORM::factory('album',$this->request->param('id'));
    $images = $album->images->find_all();
    
    foreach ($images as $key=>$image) {
        $columns['images']['options'][$image->id]='/images/dynamic/'.$image->filehash.'/130x130xfit.'.$image->ext;
    }
    
    if ($_POST &&is_array($export=Arr::get($_POST,'images',false))) {
        
        //$this can run slow  - run as a background process
        
        //get post url
        $url = URL::Site($this->request->url(array('action'=>'exportgo')),'http');
        
        //get all post data as sting array
        $export_string='';
        foreach($export as $key=>$value) { $export_string .= "images[$key]=$value&"; }
        rtrim($export_string,'&');
        
        //include session
        $sess_id=Session::instance()->id();
        $export_string.='&session='.$sess_id;
 
        //Run request 
        $parts=parse_url($url);
        $fp = fsockopen($parts['host'],
            isset($parts['port'])?$parts['port']:80,
            $errno, $errstr, 30);
    
        $out = "POST ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($export_string)."\r\n";
        $out.= "Connection: Close\r\n\r\n";
        if (isset($export_string)) $out.= $export_string;
        fwrite($fp, $out);
        fclose($fp);
        
        //finnish up     
      Hint::set(Hint::SUCCESS,count($export)." images sent to to Facebook, it may take a while for the import to finish");
      $this->request->redirect($this->request->initial()->uri(array('action'=>'index'))); 
  }
}

public function action_exportgo(){
if ($this->request->param('id')<1) {throw exception;}

    $fb=$this->connect();
    $facebook=$fb->link; 
    if (!$facebook) return;
    
    $columns=$this->_model;
    $data = Arr::extract($_POST, array('images'),false);
          
    $album = ORM::factory('album',$this->request->param('id'));
    $images = $album->images->find_all();
    
    foreach ($images as $key=>$image) {
        $columns['images']['options'][$image->id]='/images/dynamic/'.$image->filehash.'/130x130xfit.'.$image->ext;
    }
    
    if ($_POST &&is_array($export=Arr::get($_POST,'images',false))) {
    
    //At the time of writing it is necessary to enable upload support in the Facebook SDK, you do this with the line:
      $facebook->setFileUploadSupport(true);
      
      
      $album_name=strip_tags(($album->parent->type=='multiview')?"{$album->parent->name} - {$album->name}":"{$album->name}");
      $album_desc=strip_tags(($album->parent->type=='multiview')?"{$album->parent->desc} - {$album->desc}":"{$album->desc}");
        
      //Create an album
      $album_details = array(
              'message'=> $album_desc.' -taken by Alec Maxwell Photography (http://alecmaxwell.co.uk)',
              'name'=> $album_name
      );
      $create_album = $facebook->api('/me/albums', 'post', $album_details);
        
      //Get album ID of the album you've just created
      $album_uid = $create_album['id']; 
      $part=1;
      $count=0;
      foreach ($images as $key=>$image){
        if (!Arr::get($export,$image->id,false)) {continue;}
        $count++;
        //Upload a photo to album of ID...
        $photo_details = array(
          'message'=> $image->name.' -taken by Alec Maxwell Photography (http://alecmaxwell.co.uk)',
        );
        $photo_details['image'] = '@' . realpath($image->path);
          
        $upload_photo = $facebook->api('/'.$album_uid.'/photos', 'post', $photo_details);
        if ($count>99){
          $count=0;
          $part++;
          //Create an album
          $album_details = array(
                  'message'=> $album_desc.' -taken by Alec Maxwell Photography (http://alecmaxwell.co.uk)',
                  'name'=> $album_name." part $part" 
          );
          $create_album = $facebook->api('/me/albums', 'post', $album_details);
            
          //Get album ID of the album you've just created
          $album_uid = $create_album['id'];
        }  
      }
      Hint::set(Hint::SUCCESS,count($export)." images have finished uploading to Facebook");
      $this->request->redirect($this->request->initial()->uri(array('action'=>'view'))); 
    }
}

  public function action_export2(){
  // Awesome Facebook Application
  //
  // Name: Evography
  //
    if ($this->request->param('id')<1) {throw exception;}

    $fb=$this->connect();
    $facebook=$fb->link; 
    if (!$facebook) return;
    
    $columns=$this->_model;
    $data = Arr::extract($_POST, array('images'),false);

    
    $this->template->content = View::factory('pages/admin/facebook-export')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors)
      ->bind('user', $fb->user)
      ->bind('logoutUrl', $fb->logoutUrl)
      ->bind('loginUrl', $fb->loginUrl);
    
          
    $album = ORM::factory('album',$this->request->param('id'));
    $images = $album->images->find_all();
    
    foreach ($images as $key=>$image) {
        $columns['images']['options'][$image->id]='/images/dynamic/'.$image->filehash.'/130x130xfit.'.$image->ext;
    }
    
    if ($_POST &&is_array($export=Arr::get($_POST,'images',false))) {
     //At the time of writing it is necessary to enable upload support in the Facebook SDK, you do this with the line:
      $facebook->setFileUploadSupport(true);
      
      
      $album_name=strip_tags(($album->parent->type=='multiview')?"{$album->parent->name} - {$album->name}":"{$album->name}");
      $album_desc=strip_tags(($album->parent->type=='multiview')?"{$album->parent->desc} - {$album->desc}":"{$album->desc}");
        
      //Create an album
      $album_details = array(
              'message'=> $album_desc.' -taken by Alec Maxwell Photography (http://alecmaxwell.co.uk)',
              'name'=> $album_name
      );
      $create_album = $facebook->api('/me/albums', 'post', $album_details);
        
      //Get album ID of the album you've just created
      $album_uid = $create_album['id']; 
      $part=1;
      $count=0;
      foreach ($images as $key=>$image){
        if (!Arr::get($export,$image->id,false)) {continue;}
        $count++;
        //Upload a photo to album of ID...
        $photo_details = array(
          'message'=> $image->name.' -taken by Alec Maxwell Photography (http://alecmaxwell.co.uk)',
        );
        $photo_details['image'] = '@' . realpath($image->path);
          
        $upload_photo = $facebook->api('/'.$album_uid.'/photos', 'post', $photo_details);
        if ($count>99){
          $count=0;
          $part++;
          //Create an album
          $album_details = array(
                  'message'=> $album_desc.' -taken by Alec Maxwell Photography (http://alecmaxwell.co.uk)',
                  'name'=> $album_name." part $part" 
          );
          $create_album = $facebook->api('/me/albums', 'post', $album_details);
            
          //Get album ID of the album you've just created
          $album_uid = $create_album['id'];
        }  
      }
      Hint::set(Hint::SUCCESS,count($export)." images successfully imported to Facebook");
      $this->request->redirect($this->request->initial()->uri(array('action'=>'view')));   
    }
  }
  
  
  public function get_fb_albums(){
    if( ! $facebook=Facebook::factory() ) return Facebook::login();
     $columns=$this->_model;
    $albums = $facebook->get('/me/albums?limit=0');
    foreach ($albums['data'] as $key=>$album) {
      $columns['album']['options'][$album['id']]="{$album['name']} - ". Arr::get($album,'count',0)." images";
    }
  
    $view = View::factory('admin/facebook/albums')
      ->bind('columns',$columns)    
      ->bind('data',$post)
      ->bind('errors',$errors);
      
    $post=$this->request->initial()->post();
    
    return $view;
  }
  
  public function get_fb_images(){
    if( ! $facebook=Facebook::factory()) return Facebook::login();
    $columns=$this->_model; 
    if ($post=$this->request->initial()->post()) {
      if ( $album_id = Arr::get($post,'album')) {
        //album is set, get facebook images
        $images = $facebook->get("/{$album_id}/photos/?fields=id,picture,images,from&limit=0");
        foreach ($images['data'] as $key=>$image) {
          $columns['images']['options'][$key]=Arr::get($image,'picture',0);
        }
        $view = View::factory('admin/facebook/images')
          ->bind('album',$album_id)
          ->bind('columns',$columns)
          ->bind('data',$post)
          ->bind('errors',$errors)
          ;
        
        //import is set, import selected images
        if (is_array($import=Arr::get($post,'images',false) ) ) {
          $image=$images['data'];
          unset($_POST['images']);
          foreach ($import as $id=>$tick) {
            $this->import_image( $image[$id]['images'][0]['source'] );
          }
        }
      }
    return $view;
    }   
  }
  
  public function import_image($source){
        //Get local 
        $user_id=$this->user_id;
        $album_id=$this->request->param('id');
        
        $path = DOCROOT."images/uploads/{$user_id}/{$album_id}/";
        
			  if (!is_dir($path)) {
			   mkdir($path,0777,true);
			  }
			  
			  $file=pathinfo($source);	
			  $filename     =$file['basename'];
			  $name		      =$file['filename'];	
			  $ext          =strtolower($file['extension']);
			  $hash         =uniqid();
			  $new_filename ="{$hash}.{$ext}";
			  
        $get=file_get_contents($source);
        $put=file_put_contents($path.$new_filename,$get);
        $filepath=$path.$new_filename;
        
		    $size         =filesize($source);
		 	  list($width,$height) = @getimagesize($filepath);
		 	  
		 	  $_POST['filepath']=$filepath;
		 	  $_POST['file']=$file;
		 	  $_POST['filename']=$filename;
		 	  $_POST['name']=$image[$id]['id'];
		 	  $_POST['ext']=$ext;
		 	  $_POST['hash']=$hash;
		 	  $_POST['new_filename']=$new_filename;
		 	  $_POST['size']=$size;
		 	  $_POST['width']=$width;
		 	  $_POST['height']=$height;
		 	  
		 	  $_POST['source']='facebook';
		 	  $_POST['fb_user']=$image[$id]['from']['id'];
		 	  $_POST['fb_user_name']=$image[$id]['from']['name'];
		 	  $_POST['fb_date']=$image[$id]['created_time'];
		 	  
        //insert into DB
        $request = Request::factory("admin/album/$album_id/upload/");
        $request->execute();
  }
  
  public function action_albums(){
    $this->template->content=$this->get_fb_albums();
  }
  public function action_images(){
    $this->template->content=$this->get_fb_images();
  }
  public function action_import(){
    if( ! $facebook=Facebook::factory() ) {
      return $this->template->content = Facebook::login();
    }
    $this->template->content = View::factory('admin/facebook/import')
      ->set('user', $facebook->user() )
      ->set('albums',  $this->get_fb_albums() )
      ->set('images',  $this->get_fb_images() )
      ;
  }
  
  
  
  
  public function action_import2(){
   $facebook=Facebook::factory(); 
   
   if (! $facebook->user() ) {
      return $this->template->content=Facebook::login('Connect to facebook');
   }
    
   $this->template->content = View::factory('pages/admin/facebook-import')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors)
      ->set('user', $facebook->user_details())
      ->bind('logoutUrl', $fb->logoutUrl)
      ->bind('loginUrl', $fb->loginUrl);
    
     
    $columns=$this->_model;
    $data = Arr::extract($_POST, array('album', 'images'),false);
    
   
    
    $albums = $facebook->app->api('/me/albums?limit=0', 'get');
    foreach ($albums['data'] as $key=>$album) {
      $columns['album']['options'][$album['id']]="{$album['name']} - ". Arr::get($album,'count',0)." images";
    }
    
    if ($album=Arr::get($data,'album')){
      $images = $facebook->app->api("/$album/photos/?fields=id,picture,images,from&limit=0", 'get');
      foreach ($images['data'] as $key=>$image) {
        $columns['images']['options'][$key]=Arr::get($image,'picture',0);
      }
      
    }
    
    if ( $album=Arr::get($_POST,'album',false)&&is_array($import=Arr::get($_POST,'images',false)) ) {
    //user details
    /*
 $fb_user=ORM::factory('user_facebook',$fb->user->id);
     if ($fb_user->user_id){
       $user=$fb_user->user;
     } else {
       $user=ORM::factory('user');
       $user->set('username',"{FACEBOOK::$fb->user->id}");
       $user->set('email',"{$fb->user->id}");
       $user->set('name',"{$fb->user->name}");
       $user->save();
       $fb_user->set('user_id',$user->id)->save();
     }
*/
     
      $image=$images['data'];
      unset($_POST['images']);
      foreach ($import as $id=>$tick) {
        //Get File@ $id['source']
        $remote=$image[$id]['images'][0]['source'];
        //Get local 
        $user_id=$this->user_id;
        $album_id=$this->request->param('id');
        $path = DOCROOT."images/uploads/{$user_id}/{$album_id}/";
			  if (!is_dir($path)) {
			   mkdir($path,0777,true);
			  }
			  
			  $file=pathinfo($remote);	
			  $filename     =$file['basename'];
			  $name		      =$file['filename'];	
			  $ext          =strtolower($file['extension']);
			  $hash         =uniqid();
			  $new_filename ="{$hash}.{$ext}";
			  
        $get=file_get_contents($remote);
        $put=file_put_contents($path.$new_filename,$get);
        $filepath=$path.$new_filename;
        
		    $size         =filesize($filepath);
		 	  list($width,$height) = @getimagesize($filepath);
		 	  
		 	  $_POST['filepath']=$filepath;
		 	  $_POST['file']=$file;
		 	  $_POST['filename']=$filename;
		 	  $_POST['name']=$image[$id]['id'];
		 	  $_POST['ext']=$ext;
		 	  $_POST['hash']=$hash;
		 	  $_POST['new_filename']=$new_filename;
		 	  $_POST['size']=$size;
		 	  $_POST['width']=$width;
		 	  $_POST['height']=$height;
		 	  
		 	  $_POST['source']='facebook';
		 	  $_POST['fb_user']=$image[$id]['from']['id'];
		 	  $_POST['fb_user_name']=$image[$id]['from']['name'];
		 	  $_POST['fb_date']=$image[$id]['created_time'];
		 	  
        //insert into DB
        $request = Request::factory("admin/album/$album_id/upload/");
        $request->execute();
      }
        $_POST['images']=$import;
        //reset and return;
        Hint::set(Hint::SUCCESS,count($import)." images successfully imported from Facebook");
        $this->request->redirect($this->request->uri(array('controller'=>'album','action'=>'view')));    
    }
    
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
     //user details
    /*
 $fb_user=ORM::factory('user_facebook',$fb->user->id);
     if ($fb_user->user_id){
       $user=$fb_user->user;
     } else {
       $user=ORM::factory('user');
       $user->set('username',"{FACEBOOK::$fb->user->id}");
       $user->set('email',"{$fb->user->id}");
       $user->set('name',"{$fb->user->name}");
       $user->save();
       $fb_user->set('user_id',$user->id)->save();
     }
*/
     
     $comment=ORM::factory('comment');
     $comment
      ->set('user_id',$this->user_id)
      ->set(Arr::get($_POST,'fb_type').'_id',$this->request->param('id'))
      ->set('message',Arr::get($_POST,'fb_message'))
      ->set('source',Arr::get($_POST,'source'))
      ->set('add_date',Arr::get($_POST,'add_date'));
     
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
     
      if (Arr::get($_POST,'fb_post_feed',false)){
        $data = array(
           'message' => "Commented the {$comment->album->name} for {$comment->album->parent->name}'s online gallery: {$comment->message}",
           'link' => URL::site($this->request->initial()->url(array('action'=>'')),'http'),
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
    $facebook = new Facebook(array(
      'appId' => '187899894592528',
      'secret' => '9393a389804fe69026e737d0aed27696',
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
           if (!$this->user_id){
             $user=ORM::factory('user',array('username'=>$user_profile['id']));
             if (!$user->id) {
               $user->set('username',"{$user_profile['id']}");
               $user->set('password',"{$user_profile['id']}");
               $user->set('email',"{$user_profile['id']}@facebook.com");
               $user->set('name',"{$user_profile['name']}");
               $user->save();
             }
             $this->user_id=$user->id;
           } else {
             $user=ORM::factory('user',$this->user_id);
           }
           
           //if no paired fb account, make one
           if (!$user->facebook->id) {
              $facebook_user = ORM::factory('user_facebook');
                $facebook_user->values($user_profile,array('id','name','link','picture','updated_time'));
                $facebook_user->set('user_id',$this->user_id);
                $facebook_user->save();
           }
           //is the user fb id and the one we are accessing the same?
           if ($user->facebook->id==$user_profile['id']) {
            $user->facebook->values($user_profile,array('picture','updated_time'))->save();
            $facebook_user=$user->facebook;
           } else {
             Hint::set(Hint::ERROR,"You already have a Facebook account paired to this user account, you may only have one.");
             $facebook_user=false; 
           }
         // $facebook_user=$user->facebook;
    } else {
        $facebook_user=false;
       // $facebook=false;
        //echo "Connect with FB to use this feature!";
        return (object) $data;
    }
   $data['user']=$facebook_user;
   
    
   return (object) $data;//$facebook;
  }

}
       
 ?>
