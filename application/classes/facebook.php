<?php
class Facebook {

  // this stores the singleton FacebookApi
  protected static $instance = null;

  // this is the singleton's Facebook instance
  protected $app = null;


  private $user=null;
  
   /**
	 * Creates a new Facebook singleton object.
	 *
	 * @param   array  configuration
	 * @return  Pagination
	 */
  private static function instance()
	{ 
	  if (!isset(self::$instance)) {
      self::$instance = new Facebook();
    }
   // if (!self::$instance->user()) return false;
    return self::$instance;
	}

  
  //this will only return an instance if the user is authorised, we can chack login like  - if (! Facebook::factory() ) Facebook::login();
	public static function factory()
	{ 
	  $instance=self::instance();
	  return $instance->user() ? $instance : false;
  }

	/**
	 * Creates a new Facebook object.
	 *
	 * @param   array  configuration
	 * @return  void
	 */
	public function __construct()
	{
	//=new Facebook();
		//return $this;
		// Overwrite system defaults with application default
		$this->app=new Facebook_facebook(Kohana::config('facebook'));
		//if (! $this->user() ) 
    return $this;
	}
 
  function user(){
     if ( isset($this->user) ) return $this->user;
     
     
     if  (!  $this->app->getUser() ) return false;
     try {
        return $this->user = (object) $this->app->api('/me?fields=id,picture,updated_time,link,name,email');
       } catch(FacebookApiException $e){
         //access has expired
         return false;
       }
     
     //if (!$user)  false;   
 }
 
 function get($uri){
   return $this->app->api($uri,'get');
 }
 
   static function login($message='Login with Facebook',$scope='email,user_photos,publish_stream'){
      $facebook=self::instance();
      $url=$facebook->app->getLoginUrl(array('scope'=>$scope));

    return '<a href="' . $url. '" class="btn facebook-login">'.$message.'</a>';
  }
  
  static function like($url=false) {
    if (!$url) $url=Request::current()->url();
    if (is_array($url)) $url=Request::current()->url($url);
    $url=URL::site($url,'http');
    return View::factory('admin/facebook/login')->bind('url',$url);
  }
   
}