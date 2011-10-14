<?php defined('SYSPATH') or die('No direct script access.');
class Controller_System_DynamicImage extends Controller {
	var $base;
	var $debug=1;
	
	function action_index(){
		 //$this->base=dirname(dirname(DOCROOT))."/alecmaxwell.com/http";
		 $this->base=DOCROOT;
		 return $this->resize();
	}
	
	function resize(){
     $hash   = $this->request->param('id');
     $width  = $this->request->param('width');
     $height = $this->request->param('height');
     $mode   = $this->request->param('mode');
     $format = $this->request->param('format');
     $pin    = $this->request->param('pin');
		
		$this->fail_url="http://dummyimage.com/{$width}x{$height}/d2/fff.{$format}";
     
		$base=$this->base;
		//$img=new Model_Image();
		//$record=$img->getFromHash($hash);
		
		$image = ORM::factory('image');
		$record=$image->where('filehash', '=', $hash)->find();
		
		//old not found
		if (empty($record)) {$this->fail("no matching record (hash:$hash)");}
		
		
		//trying to cache out of date links due to crops / rotates and watermarks.
		/*
		if (empty($record)) {
		  $new=ORM::factory('image_hashhistory',$hash)->new
		  if ($new->filehash) 
		  {
		    $this->request->redirect($this->request->url(array('id'=>$new->filehash)));
		  }
		  //else
			$this->fail("no matching record (hash:$hash)");
		}
		*/
		
		//echo $base.$record['path'];
		try {
		  $file=trim($record->path,'/');
		  $image = Image::factory($base.$file);
		} catch (Exception $e){
			$this->fail("could not load file (path:$base$file)");
		}
		
		if (!$width) $width=$record->width;
		if (!$height) $width=$record->height;
		
//		Allows us to pin an image when croping;
		switch ($pin){
		 case '-t':
		  $x=0;
		  $y=null;
		 break;
		case '-tl':
		  $x=0;
		  $y=0;
		 break;
		case '-tr':
		  $x=0;
		  $y=true;
		 break;
		case '-b':
		  $x=true;
		  $y=null;
		 break;
		case '-bl':
		  $x=true;
		  $y=0;
		 break;
		case '-br':
		  $x=true;
		  $y=true;
		 break;
		case '-l':
		  $x=null;
		  $y=0;
		 break;
		case '-r':
		  $x=null;
		  $y=true;
		 break;
		default:
		  $x=$y=null;
		 break;
		}
		
		if ($record->rotate){
		  if ($image->width >1280 || $image->height >1280) {
		    $image->resize(1280,1280,Image::AUTO);
		  }
		  $image->rotate(90*$record->rotate);
		}
		
		switch ($mode) {
    	case 'force':
    		$image->resize($width, $height, Image::NONE); // resize regardless of origianl aspect, can result in distorted image 
        break;  
    	case 'crop':
    		$image->resize($width, $height, Image::INVERSE); //resize to smallest dimention, makes image larger than we desire
    		$image->crop($width, $height, $x, $y); //crop to make fully filled image exact size we asked for with correct aspect ratio
    		$mode="{$mode}{$pin}"; 
    		break;
    	case 'width':
    		$image->resize($width, $height, Image::WIDTH);//Fixed width regardless of hight ratio, may have a small height than desired
    		break;
    	case 'height':
        $image->resize($width, $height, Image::HEIGHT);//Fixed height regardless of width ratio, may have a small width than desired
        break;
    	case 'fit':
    	default:
    		$image->resize($width, $height, Image::AUTO); //fully preserves aspect ration within the height and width constraints
    		break;	
    }
    
    $watermark=$record->watermark();
    if ($watermark->active){
      $this->watermark($image,$watermark);
    }
    
    //$mark = Image::factory('upload/watermark.png');
    //$image->watermark($mark, TRUE, TRUE);
    $base=DOCROOT;
    $folder="images/dynamic/$hash/";
    $file="{$width}x{$height}x{$mode}.$format";
    
    if (!is_dir($base.$folder)) {mkdir($base.$folder, 0777, true);}
    
		$image->save($folder.$file,80);
		if (!file_exists($base.$folder.$file)) {
		    $this->fail("Could not create new file ({$base}$folder{$file})");
		};
    $this->request->redirect('/'.$folder.$file);
    die();
	}
	
	function watermark(&$image,$watermark){
	  $mark = Image::factory($this->base.$watermark->path);
	  //Only do watermarking if image is bigger than mark 
	  if ($mark->width>$image->width || $mark->height>$image->height) return;
	  switch (strtolower($watermark->position)){
	  CASE 'top left':
	    $x=$y=0;
	   break;
	  CASE 'top right':
	    $x=true;
	    $y=0;
	   break;
	  CASE 'bottom left':
	    $x=0;
	    $y=true;
	   break;
	  CASE 'bottom right':
	    $x=$y=true;
	   break;
	  CASE 'center':
	    $x=$y=null;
	   break;
	  }
    $image->watermark($mark, $x, $y, $watermark->opacity);
	}
	
	function fail($msg){
		  if ($this->debug) {
		  	echo $msg;
		  	die();
		  	return;
		  	
		  }
	  $this->request->redirect($this->fail_url);  
      die();	
	
	}
}