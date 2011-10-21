<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Gallery_Album extends Controller_Gallery_Album_Master {

	function action_photobook(){
	  $_REQUEST['current']['type']='photobook';
	  $_REQUEST['current']['limit']=Arr::get($_REQUEST['current'],'limit',0);
	  $setting=array(
	    'photobook'=>array('height'=>260,'width'=>850),
	  );
	  $this->template->script_options->merge($setting);
	  
	  return $this->action_view();
	}

	function action_big(){
	  $_REQUEST['current']['type']='big';
	  $_REQUEST['current']['limit']=Arr::get($_REQUEST['current'],'limit',3);
	  return $this->action_view();
	}
	
	function action_grid(){
	  $_REQUEST['current']['type']='grid';
	  
	  $_REQUEST['current']['limit']=($this->request->param('format')=='.part')?21:Arr::get($_REQUEST['current'],'limit',42);
	  $setting=array(
	    'preload'=>true,
	  );
	  $this->template->script_options->merge($setting);
	  
	  return $this->action_view();
	}
	
  function action_slideshow(){
	  $_REQUEST['current']['type']='slideshow';
	  return $this->action_view();
	}

	
  function action_wall(){
	  $_REQUEST['current']['type']='wall';
	  return $this->action_view();
	}
	
  function action_polaroid(){
	  $_REQUEST['current']['type']='polaroid';
	  $_REQUEST['current']['limit']=($this->request->param('format')=='.part')?40:Arr::get($_REQUEST['current'],'limit',80);
	  $_REQUEST['current']['height']=($this->request->param('format')=='.part')?300:Arr::get($_REQUEST['current'],'height',500);
	  $js=array('fade'=>array('speed'=>10000),'drag'=>array('rain'=>true), 'lightbox'=>false, 'lazyload', 'scrollload');
	  $this->template->script_options->merge($js);
	  return $this->action_view();
	}
	
  function action_magazine(){
	  $_REQUEST['current']['type']='magazine';
	  
	  //if not overridden set this to a multiple of 3
	  $_REQUEST['current']['limit']=($this->request->param('format')=='.part')?6:Arr::get($_REQUEST['current'],'limit',15);
	  $this->template->script_options->merge(array('lightbox'=>false,));

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