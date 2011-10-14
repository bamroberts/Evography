<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Album extends Controller_Admin_Album_Core {
  protected $_fields=array('name', 'desc', 'published','comments','cart','facebook','private','theme','export','open');
  
  public function action_index(){    
      if ($id=$this->request->param('id')){
        $this->template->content = View::factory('pages/admin/album-details')
            ->bind('album', $album);
        $album=Orm::factory($this->_model,$id);
      } else {
        $collections=ORM::factory($this->_model,$this->id)
          ->get_descendants(false,'ASC',False,false,false,array(array('column'=>'type','operator'=>'=','value'=>$this->request->controller())));
    
        $this->template->content=View::factory('/admin/blocks/collection')
          ->bind('collection',$collections);
      }    
  }
  
  public function action_edit(){
    $this->_fields[]='open';
    $this->_fields[]='cart';
    $this->_fields[]='comments';
    return parent::action_edit();
  }
  
   function action_upload(){  
    // $this->template->scripts=array(
    //      'assets/javascript/Swiff.Uploader.js',
    //      'assets/javascript/Fx.ProgressBar.js',
    //      'assets/javascript/FancyUpload2.js',
    //      'assets/javascript/system.js',
    //      );
  	
    $this->template->content = View::factory('pages/admin/upload')
        ->bind('results', $results)
        ->bind('page_links', $page_links);
    
    $user_id=$this->user_id;
    $album_id=$this->request->param('id');
    
    $status=false;
    
    $files = new Validation($_FILES);
                $files->rules(
                    'Filedata',
                    array(
                        array('Upload::not_empty', NULL),
                        array('Upload::valid' , NULL),
                        array('Upload::size', array(':value','20M')),
                        array('Upload::type' , array(
                            ':value',
                            array('jpg', 'png', 'gif', 'jpeg')
                        )),
                    )
                );	
    
    if (!$this->request->is_initial() && $filepath=Arr::get($_POST,'filepath',false))
    {   
                         //$filepath=Arr::get($_POST,'filepath',false);
                         $file=Arr::get($_POST,'file',false);
                         $filename=Arr::get($_POST,'filename',false);
                         $name=Arr::get($_POST,'name',false);
                         $ext=Arr::get($_POST,'ext',false);
                         $hash=Arr::get($_POST,'hash',false);
                         $new_filename=Arr::get($_POST,'new_filename',false);
                         $size=Arr::get($_POST,'size',false);
                         $width=Arr::get($_POST,'width',false);
                         $height=Arr::get($_POST,'height',false);
                         
                         
    } elseif ($_FILES)  { 
       //start method 2 {
  $targetDir=     DOCROOT."images/uploads/{$user_id}/{$album_id}/";
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

// Return JSON-RPC response
//die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');


       
       
       //}
      	
       //if($files->check()) {
             
                
    			//$path = DOCROOT."images/uploads/{$user_id}/{$album_id}/";
    			//if (!is_dir($path)) {
    			//  mkdir($path,0777,true);
    			//}
    			$file=pathinfo($targetDir . DIRECTORY_SEPARATOR . $fileName);
    			//$file=pathinfo($_FILES['Filedata']['name']);	
    			echo debug::vars($file);
    			$filename     =$file['basename'];
    			$name		      =$file['filename'];	
    			$ext          =strtolower($file['extension']);
    			
    			$hash         =uniqid();
    			
    			$new_filename ="{$hash}.{$ext}";
    			
    			$filepath=$targetDir . DIRECTORY_SEPARATOR . $fileName;
    			//$filepath=Upload::save($_FILES['Filedata'], $new_filename, $path, 0777);
    		    $size         =filesize($filepath);
    			list($width,$height) = @getimagesize($filepath);
    			
    			
     // } else {	
    //  return; 
		//    $return = array(
		//	 'status' => '0',
		//	 'error' => "Upload and server side validation failed"
		//	   );
			   
    //  }
   
   } else {
      return;
   }
		//STORE IMAGE IN DB	
		//Get filename and path parts	
		 //if passed checks save image in new home 
      $user_id=Auth::instance()->get_user();
      $album_id=$this->request->param('id');
		 //Get exif photodata
		  $meta=exif_read_data($filepath);
			  $camdata["Make"]        =Arr::get($meta, 'Make');
			  $camdata["Model"]       =Arr::get($meta, 'Model');
			  $camdata["Aperture"]    =Arr::get(Arr::get($meta, 'COMPUTED'), 'ApertureFNumber');
			  $camdata["Exposure"]    =Arr::get($meta, 'ExposureTime');
			  $camdata["ISO"]         =Arr::get($meta, 'ISOSpeedRatings');
			  $camdata["Orientation"] =Arr::get($meta, 'Orientation')==1?'Landscape':'Portrait';
			  $camdata["Lens"]  	  =Arr::get($meta, 'UndefinedTag:0x0095');
			  $camdata["Focal Length"]=Arr::get(Arr::get($meta, 'UndefinedTag:0x0002'), 1);
		  $record["meta"]=serialize($camdata);
		  $record["rotate"]=(Arr::get($meta, 'Orientation',1)) -1;
		  
		  $record["filehash"] =$hash;
		  $record["filename"] =$filename;
		  $record["path"]     =str_replace('\\','/',str_replace(DOCROOT,'',$filepath)); 
      
      if ($record["rotate"]==0){
		   $record["width"]    =$width;
		   $record["height"]   =$height;
		  } else {
		   $record["width"]    =$height;
		   $record["height"]   =$width;
		  }
		  
		  $record["size"]     =$size;
		  
		  $record["ext"]      =$ext;
		  $record["taken"]    =date('Y-m-d H:i:s',time(Arr::get($meta, 'DateTime')));
		  $record["name"] 	  =$name;
		  $record["active"]   =1;
		  
		  $record["add_user_id"]= $user_id;
		  $record["mod_user_id"]= $user_id;
		  $record["add_date"]= date('Y-m-d H:i:s');
		  $record["mod_date"]= date('Y-m-d H:i:s');
		  $record["album_id"]= $album_id;
		  $record['order']= ORM::factory('album',$album_id)->images->order_by('order','DESC')->find()->order + 1;
		  
		  $record["source"]=Arr::get($_POST,'source','internal');
		  
		  $image=ORM::factory('image');
	      $image->values($record);
	      $image->check();
	      $image->save();
	      $image->add('albums', $album_id);

		  $return=$image->as_array();	
		  $return['status']=1;
		  
  
	
   //if ($this->request->initial()->is_ajax() || Request::$user_agent=='Adobe Flash Player 10'||Arr::get($_GET,'ajax',false)||$this->is_ajax) {
   if ($this->is_ajax) {
            $return["jsonrpc"] = "2.0";
            $return["result"] = null;
            $return["id"] = "id";
            $_POST['json']=$return;
            return;
    } else {
      Hint::set(Hint::SUCCESS,"Your image was successfully uploaded.");
		  $this->request->redirect($this->request->initial()->uri(array('action'=>'')));
    }  
  }
  
  
  public function action_organise(){
  	$album=ORM::factory( 'album', $this->request->param('id') );
  	$images=$album->images->order_by('order')->find_all();
  	
  	$count=$album->images->count_all();
  	
  	
  	$fix=$album->images->where('order','<','1')->count_all();
  	if ($fix) {
  		$order=1;
  		foreach ($images as $image) {
  		  $image->set('order',$order++);
  		  $image->save();
  		}	
  	}
  	
  	$this->template->content = View::factory('pages/admin/organise')
			->bind('images', $images);
	//actions		
  	if ($_REQUEST) {
  	  Switch ($_REQUEST['mode']){
  	  	CASE 'swap':
  	  	  $a=ORM::factory('image',$_REQUEST['a']);
  	  	  $b=ORM::factory('image',$_REQUEST['b']);
  	  	  
  	  	  $temp=$a->order;
  	  	  
  	  	  $a->set('order',$b->order);
  	  	  $a->save();
  	  	  
  	  	  $b->set('order',$temp);
  	  	  $b->save();
  	  	  
  	  	  //$this->request->redirect(Request::current()->uri());
  	  	break;	
  	  	CASE 'first':
  	  	  $order=2;
  	  	  foreach($images as $image) {
  	  	    if ($image->id==$_REQUEST['image']) {
  	  	    
  	  	
  	  	      $image->set('order',1);
  	  	      //echo 'image-'. $image->order;
  	  	      $image->save();
  	  	    } else {
  	  	      $image->set('order',$order++)->save();
  	  	    }
  	  	  }
  	  	break;
  	  	CASE 'last':
  	  	  $order=1;
  	  	  foreach($images as $image) {
  	  	    if ($image->id==$_REQUEST['image']) {
  	  	
  	  	      $image->set('order',$images->count())->save();
  	  	    } else {
  	  	    $image->set('order',$order++)->save();
  	  	    }
  	  	  }
  	  	break;
  	  	CASE 'sort':
  	  	  $array=explode(',',Arr::get($_REQUEST,'order',false));
  	  	  if (!is_array($array)) return;
  	  	    $sql="INSERT INTO `images` (`id`,`order`) VALUES ";
  	  	    foreach ($array as $order=>$id) {
  	  	      if ($id){
  	  	        $sql.="($id,$order), " ;
  	  	      }
  	  	    }
  	  	    $sql=trim($sql,', ')." ON DUPLICATE KEY UPDATE `order`=VALUES(`order`);";
            DB::query(Database::INSERT, $sql, FALSE)->execute();
            //echo $sql; return;
  	  	break;
  	    DEFAULT;
  	  	}
  	  	if ($this->request->initial()->is_ajax() || Arr::get($_GET,'ajax',false)) {
          $this->json['status']='New order saved';
          return;
        }
  	  	$this->request->redirect($this->request->uri());
  	}
  	
  }
  
   public function action_download(){
 // echo phpinfo(); return;
  
    //path to directory to scan
    $directory = "/images/uploads/{$this->user_id}/".$this->request->param('id');
    $files = glob(DOCROOT . $directory . "/*");
    //get all image files with a .jpg extension.
    
    $destination = "/images/zips/{$this->user_id}.zip";
    
    //zip files
    $result = $this->create_zip($files,DOCROOT.$destination,true);
    //redirect to zip file
    $this->request->redirect($destination);
  }
  
  //zip's up album
  function create_zip($files = array(),$destination = '',$overwrite = false) {
      //if the zip file already exists and overwrite is false, return false
      if(file_exists($destination) && !$overwrite) { return false; }
      //vars
      $valid_files = array();
      //if files were passed in...
      if(is_array($files)) {
        //cycle through each file
        foreach($files as $file) {
          //make sure the file exists
          if(file_exists($file)) {
            $valid_files[] = $file;
          }
        }
      }
      //if we have good files...
      if(count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
          return false;
        }
        //add the files
        foreach($valid_files as $file) {
          $filepath =pathinfo($file);	
    			$filename =$filepath['basename'];
          $zip->addFile($file,$filename);
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
        
        //close the zip -- done!
        $zip->close();
        
        //check to make sure the file exists
        return file_exists($destination);
      }
      else
      {
        return false;
      }
  }
  
  public function action_empty(){
   //remove image links
  }
  public function action_set_cover(){
    $data=Arr::merge($_POST,$_GET);
    if ($data){
      $album= ORM::factory('album',$this->request->param('id'));
      if ($album->id AND $cover=ARR::get($data,'cover') AND $album->images->find($cover) ) {
        $album->set('cover_image_id',$cover)->save();
      }
    }
    if ($this->request->is_ajax()) {
        $this->json=$album->cover->as_array();
        return;
    }
      $this->request->redirect($this->request->uri(array('action'=>'')));
  }
  
}