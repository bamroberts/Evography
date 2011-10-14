<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Album extends Controller_Gallery_Album_Master {

  //function before(){
  //  parent::before();
  //  
  //}

	function action_big(){
	  $_REQUEST['current']['type']='album-big';
	  return $this->action_view();
	}
	
  function action_wall(){
	  $_REQUEST['current']['type']='blocks/album-wall';
	  return $this->action_view();
	}
	
  function action_polaroid(){
	  $_REQUEST['current']['type']='blocks/album-polaroid';
	  $_REQUEST['current']['limit']=Arr::get($_REQUEST['current'],'limit',100);
	  $_REQUEST['current']['height']=Arr::get($_REQUEST['current'],'height',500);
	  return $this->action_view();
	}
	
  function action_book(){
	  $_REQUEST['current']['type']='blocks/album-book';
	  
	  //if not overridden set this to a multiple of 3
	  $_REQUEST['current']['limit']=Arr::get($_REQUEST['current'],'limit',15);
	 // $this->template->scripts=array('preloader, lightbox, lazyload, scrollload')
	  $js=array('preloader'=>array('fade'=>true,'async'=>false), 'lightbox', 'lazyload', 'scrollload');
	  //$this->template->js_load($js);
	 
	  return $this->action_view();
	}
	
		
	function action_upload(){
	  $album=ORM::factory('album',$this->request->param('id'));
	  if(!$album->open) {
	   throw new HTTP_Exception_404('File not found!');
	  }
	  $_REQUEST['current']['type']='album-upload';
	  
	  $this->template->scripts=array(
          'assets/javascript/Swiff.Uploader.js',
          'assets/javascript/Fx.ProgressBar.js',
          'assets/javascript/FancyUpload2.js',
          'assets/javascript/system.js',
          );
	  
	  return $this->action_view();
	}
	
	function action_export(){
	  $album=ORM::factory('album',$this->request->param('id'));
	  if(!$album->export) {
	   throw new HTTP_Exception_404('File not found!');
	  }
	  
	  
$_REQUEST['current']['type']='album-export';
	  
	  $this->template->scripts=array(
          'assets/javascript/Swiff.Uploader.js',
          'assets/javascript/Fx.ProgressBar.js',
          'assets/javascript/FancyUpload2.js',
          'assets/javascript/system.js',
          );
	  
	  return $this->action_view();

	}
	
	function action_filepost(){
	  //Rest->to(/album/17/images)->post($data)
	  $post = Request::factory("api/album/17/images.json")
	  ->heaaders('Multipart/mime')
    ->method('POST')
    ->post($_POST)
    ->execute()
    ->response;
	//this will upload a new image and return the details about it
    if ($ajax){
      return $post;
    }
    
    if($post['status']==200){
      //redirect to view page
    } 
    
    //show errors
}
	
}