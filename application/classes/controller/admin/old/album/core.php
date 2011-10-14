<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Album_Core extends Master_Admin {
	var $model='album';
	
	public function before(){
	  parent::before();
	  
	  
	  
	  $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('controller'=>'collection','action'=>'','id'=>'')),'Collections');
	  $this->id=$this->request->param('id');
	  $this->record=Orm::factory($this->model,$this->id);
	  if ($this->record->id && Route::$default_action != $this->request->action()){
	    $this->template->breadcrumb_part[]=HTML::Anchor($this->request->url(array('action'=>'')),$this->record->name);
	  }
	  //check user_id, id, action combo.
	}
	
  public function action_index(){
   if (!$this->request->param('id')) {
      $this->request->action('view');
      return $this->action_view();
   }
   $this->template->content = View::factory('pages/admin/album-details')
        ->bind('album', $data);
   $data=ORM::factory($this->model,$this->request->param('id'));
   //if (!$data->cover_image_id) ($data->set('cover_image_id',$data->images->find()->id)->save());
  }	
  
  public function action_edit(){
    return $this->action_add();
  }
  public function action_add(){
     $this->template->content = View::factory('pages/admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
      
      $fields=array('name', 'desc', 'private','comments','published');
      $data = ORM::factory($this->model,$this->request->param('id'));
      $columns = Arr::extract($data->list_columns(),$fields);
      
   if($post=$this->request->post()){
    //compolsory
    $a['mod_user_id']=Auth::instance()->get_user();
    $a['mod_date']=date('Y-m-d H:i:s');
    
    if (!$data->id) {
      $a['user_id']=Auth::instance()->get_user();
      $a['add_user_id']=Auth::instance()->get_user();
      $a['add_date']=date('Y-m-d H:i:s');
    }
    
    $data->values($a);
    $data->values($post, $fields);
    
    try {
		$data->save();
		$type=$this->request->param('id')?'updated':'created';
		Hint::set(Hint::SUCCESS,"Your record was successfully $type.");
		if ($this->request->is_initial()) {$this->request->redirect($this->request->uri(array('action'=>'','id'=>$data->id)));}

	} catch(ORM_Validation_Exception $e) {
	  $errors=$e->errors('models');
	  $type=$this->request->param('id')?'updated':'created';
      Hint::set(Hint::ERROR,"You failed to $type the record");
	}

    
    }
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
	
  public function action_view(){
  	$links=array(
  	'organise'=>array(
  	 )
  	);
  	$this->links=Arr::merge($this->links,$links);
  	return parent::action_view();
  }
 
  public function action_thumbnail(){}
  
  function action_upload(){  
     $this->template->scripts=array(
          'assets/javascript/Swiff.Uploader.js',
          'assets/javascript/Fx.ProgressBar.js',
          'assets/javascript/FancyUpload2.js',
          'assets/javascript/system.js',
          );
  	
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
       
      	
       if($files->check()) {
             
                
    			$path = DOCROOT."images/uploads/{$user_id}/{$album_id}/";
    			if (!is_dir($path)) {
    			  mkdir($path,0777,true);
    			}
    			
    			$file=pathinfo($_FILES['Filedata']['name']);	
    			$filename     =$file['basename'];
    			$name		  =$file['filename'];	
    			$ext          =strtolower($file['extension']);
    			
    			$hash         =uniqid();
    			
    			$new_filename ="{$hash}.{$ext}";
    			
    			$filepath=Upload::save($_FILES['Filedata'], $new_filename, $path, 0777);
    		    $size         =filesize($filepath);
    			list($width,$height) = @getimagesize($filepath);
    			
    			
      } else {	
      return; 
		    $return = array(
			 'status' => '0',
			 'error' => "Upload and server side validation failed"
			   );
			   
      }
   
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
		 
		  $record["filehash"] =$hash;
		  $record["filename"] =$filename;
		  $record["path"]     =str_replace('\\','/',str_replace(DOCROOT,'',$filepath)); 

		  $record["width"]    =$width;
		  $record["height"]   =$height;
		  
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
            $_POST['json']=$return;
            return;
    } else {
      Hint::set(Hint::SUCCESS,"Your image was successfully uploaded.");
		  $this->request->redirect($this->request->initial()->uri(array('action'=>'view')));
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
  public function action_delete(){
    $album=ORM::factory('album',$this->request->param('id'));
    if (!$album->id){
      $this->fof();
    }
    $parent=$album->parent;
    
    $album->delete_all();
    
    $this->request->redirect($this->request->url(array('controller'=>$parent->type,'action'=>'','id'=>$parent->id)));
    return;
  
  if ($album->children) {
   //delete children
  }
  
  
  
  $album->images->comment->delete();
  //delete contents of dynamic album / 
  $album->images->delete();  
  
  $album->comment->delete();
  $album->delete();
  }
  
  public function action_empty(){
  //delete comments
  //images
  //album
  //does $album->images->comment->delete(); work?
  
  $album = ORM::factory('album',$this->request->param('id'));
  
  $images=$album->images->find_all();
  foreach ($images as $image){
    $image->delete();
  }
  return;
  
  if ($album->id){
   /*
 if($album->images->comments->count_all()){
      $album->images->comments->delete();}
    
*/
    if ($album->images->count_all()){
    $album->images->delete();}
    //$album->comment->delete();
  
    Hint::set(Hint::SUCCESS,"All images have been removed.");
  }
  
		if ($this->request->is_initial()) {$this->request->redirect($this->request->uri(array('action'=>'')));}

  
  }
  
  public function action_export(){
    $this->template->content = View::factory('pages/admin/export');
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
  
  
  
}