<?php 
class Controller_Admin_Upload extends Controller_Admin_Album_core {
    protected $source='internal';
    protected $max_size=array('width'=>2048,'height'=>2048);
    protected $keep_original = false;
  	
  	function action_index(){
  	  $this->template->content = View::factory('admin/album/upload')
      ->bind('facebook', $facebook);
      
      $facebook = Request::factory($this->request->url(array('controller'=>'uploadFacebook')))->execute();
      
      if ($_FILES) $this->import();
      
  	}
  	
  	function import($return_file=false){
  	   $files = new Validation($_FILES);
       $files->rules('Filedata',array(   
          array('Upload::not_empty', NULL),
          array('Upload::valid' , NULL),
          array('Upload::size', array(':value','20M')),
          array('Upload::type' , array(
                  ':value', array('jpg', 'png', 'gif', 'jpeg')
                  ),
               ),
            )
        );	
    
        $album_id = $this->request->param('id');
        $user_id  = Auth::instance()->get_user();  
        
        $targetDir=     DOCROOT."images/uploads/{$user_id}/{$album_id}/";
        if (!is_dir($targetDir)) {mkdir($targetDir, 0777, true);}
        
        $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
        $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES['file']['name'];
    
        $fileName = preg_replace('/[^\w\._]+/', '', $fileName);
        
        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
        	$ext = strrpos($fileName, '.');
        	$fileName_a = substr($fileName, 0, $ext);
        	$fileName_b = substr($fileName, $ext);
        
        	$count = 1;
        	while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
        		$count++;
        
        	$fileName = $fileName_a . '_' . $count . $fileName_b;
        }
        
        // Create target dir
        if (!file_exists($targetDir))
        	@mkdir($targetDir);
        	
        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
        	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
        
        if (isset($_SERVER["CONTENT_TYPE"]))
        	$contentType = $_SERVER["CONTENT_TYPE"];
        
        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
        	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
        		// Open temp file
        		$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
        		if ($out) {
        			// Read binary input stream and append it to temp file
        			$in = fopen($_FILES['file']['tmp_name'], "rb");
        
        			if ($in) {
        				while ($buff = fread($in, 4096))
        					fwrite($out, $buff);
        			} else
        				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        			fclose($in);
        			fclose($out);
        			@unlink($_FILES['file']['tmp_name']);
        		} else
        			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        	} else
        		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
        	// Open temp file
        	$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
        	if ($out) {
        		// Read binary input stream and append it to temp file
        		$in = fopen("php://input", "rb");
        
        		if ($in) {
        			while ($buff = fread($in, 4096))
        				fwrite($out, $buff);
        		} else
        			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        
        		fclose($in);
        		fclose($out);
        	} else
        		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }
        
        $filepath=$targetDir . DIRECTORY_SEPARATOR . $fileName;
        
        $image=$this->save($filepath);
        
        
        
        if ($return_file) return $image;
        
        
        if ($this->request->param('format')=='json') {
            $return["jsonrpc"] = "2.0";
            $return["result"] = null;
            $return["id"] = "id";
            $return["status"] = "1";
            $this->template->content=json_encode($return + $image->as_array() );
            return;
      } else {
        Hint::set(Hint::SUCCESS,"Your image was successfully uploaded.");
		    $this->request->redirect($this->request->initial()->uri(array('action'=>'')));
    }  


  	}
  	
  	function save($filepath){
  	 
  	 $file=pathinfo($filepath);
  	 list($width,$height) = @getimagesize($filepath);
  	 
  	 //lets compress the file
  	 $image = Image::factory($filepath);
  	 //and resize is massive;
  	 if ($width>$max_width=Arr::get($this->max_size,'width',10000) AND $height>$max_height=Arr::get($this->max_size,'height',10000)){
  	   $image->resize($max_width,$max_height,Image::AUTO);
  	   //new with and height
  	   $width=$image->width;
		   $height=$image->height;
  	 }
  	 //do we keep the original as a backup
  	 if ($this->keep_original) {$filepath=$filepath."_r";}
  	 //save a compressed copy
  	 $image->save($filepath);
  	 
  	 try{
  	 $meta=exif_read_data($filepath);
  	 $cam_data=$this->cam_data($meta);
  	 //$date=date('Y-m-d H:i:s',time(  Arr::get($meta, 'DateTime') )) )
  	 } catch(exception $e) {
  	   $cam_data='';
  	   $meta=array();
  	 }
  	   
  	 $album = $this->node;
  	 $user_id  = Auth::instance()->get_user();
  	 
  	 $image=ORM::factory('image');
  	 $image->set('album_id'   , $album->id                        )
  	       ->set('add_user_id', $user_id                          )
  	       ->set('filehash'   , uniqid()                          )
  	       ->set('filename'   , $file['basename']                 )
  	       ->set('name'       , $file['filename']                 )
  	       ->set('ext'        , strtolower( $file['extension'] )  )
  	       ->set('active'     , 1                                 )
  	       ->set('source'     , $this->source                     )
  	       ->set('add_date'   , date('Y-m-d H:i:s')               )
  	       ->set('meta'       , $cam_data                         )
  	       ->set('path'       , str_replace('\\','/',str_replace(DOCROOT,'',$filepath))  )
  	       ->set('taken'      , date('Y-m-d H:i:s',time(  Arr::get($meta, 'DateTime',false) )) )
  	       ->set('order'      , $this->node->images->count_all() + 1 );
  	        
     if (Arr::get($meta, 'Orientation',1)) 
     {
       $image->set('width',$width)
             ->set('height',$height);
     } 
     
     else 
     {
       $image->set('rotate',1)
             ->set('width',$height)
             ->set('height',$width);
     }
  	       
     $image->check();
     $image->save();
     
     //try to copy to s3 - what do we do if this fails???
     
     $s3 = new Amazon_S3;
     $s3->upload($filepath, "{$image->filehash}.{$image->ext}", 'evography-original');
     return $image;  	
  	}
  	
    function cam_data($meta){
  	  if ( method_exists($this,$make='data_'.strtolower(Arr::get($meta, 'Make'))) )
  	  {
  	   return serialize($this->$make($meta));
      }
  	}
  	
  	function data_samsung($meta){
  	     $camdata["Make"]        = Arr::get($meta, 'Make');
			   $camdata["Model"]       = Arr::get($meta, 'Model');
			   $camdata["Aperture"]    = Arr::get( Arr::get($meta, 'COMPUTED') , 'ApertureFNumber');
			   $camdata["Exposure"]    = Arr::get($meta, 'ExposureTime');
			   $camdata["ISO"]         = Arr::get($meta, 'ISOSpeedRatings');
			   $camdata["Orientation"] = Arr::get($meta, 'Orientation')==1?'Landscape':'Portrait';
			   //user for debug
			   $camdata["Raw"]         = $meta;
			 return $camdata;
		}
  	
  	function data_canon($meta){
  	     $camdata["Make"]        = Arr::get($meta, 'Make');
			   $camdata["Model"]       = Arr::get($meta, 'Model');
			   $camdata["Aperture"]    = Arr::get( Arr::get($meta, 'COMPUTED') , 'ApertureFNumber');
			   $camdata["Exposure"]    = Arr::get($meta, 'ExposureTime');
			   $camdata["ISO"]         = Arr::get($meta, 'ISOSpeedRatings');
			   $camdata["Orientation"] = Arr::get($meta, 'Orientation')==1?'Landscape':'Portrait';
			   $camdata["Lens"]  	     = Arr::get($meta, 'UndefinedTag:0x0095');
			   $camdata["Focal Length"]= Arr::get( Arr::get($meta, 'UndefinedTag:0x0002') , 1);
			 return $camdata;
  	}
  	
  }