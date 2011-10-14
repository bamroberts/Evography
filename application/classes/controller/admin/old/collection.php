<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Collection extends Controller_Admin_Album_Core {
	var $model='album';
	
	public function before(){
	  parent::before();
    $r=$this->record=ORM::factory($this->model,$this->request->param('id'));
    if (
        Auth::instance()->logged_in('master')===FALSE
        &&
        ($r->id && $r->user_id!=$this->user_id)
     )
     {
      return $this->fof();
    }  
	}
	
  public function action_index(){  
   if (!$this->request->param('id')) return $this->action_view();
   
   $this->template->content = View::factory('pages/admin/album-details')
        ->bind('album', $data);
   $data=$this->record;  
  }	

  public function action_add(){
    /*
if(!Arr::get($this->auth,'c')) {
     return $this->fof();
    }
*/
     $data = ORM::factory($this->model,$this->request->param('id'));
     
     if ($data->id){
       $mode='Update';
     } else {
       $mode='Create';
         if ($this->user->account_type=='single'){
           Hint::set(Hint::Error,"You account only supports a single master collection");
		       $this->request->redirect($this->request->uri(array('action'=>'','id'=>$data->id)));
         }
         if ($this->user->account_type=='multi' && $this->user->credits < 1){
           Hint::set(Hint::Error,"You have run out of creddits");
		       $this->request->redirect($this->request->uri(array('action'=>'','id'=>$data->id)));
         }
     }
     
     $this->template->content = View::factory('pages/admin/edit')
   	  ->bind('columns',$columns)
      ->bind('data', $data)
      ->bind('errors', $errors);
      
      $fields=array('name', 'desc', 'private','comments','published');
      $columns = Arr::extract($data->list_columns(),$fields);
      
   if($_POST){
    //compolsory
    $a['mod_user_id']=Auth::instance()->get_user();
    $a['mod_date']=date('Y-m-d H:i:s');
    
    if (!$data->id) {
      $a['add_user_id']=Auth::instance()->get_user();
      $a['add_date']=date('Y-m-d H:i:s');
    }
    
    $data->values($a);
    $data->values($_POST, $fields);
    
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
	
  public function action_view(){
      $user_id=Auth::instance()->get_user();
      
      if (Auth::instance()->logged_in('master')) {
        $user_id='%';
      } 
      
      $collection=ORM::factory($this->model)
                        ->and_where('user_id','like ',$user_id)
                        ->and_where('parent_id','is',null)
                        ->find_all();
                        
  $this->template->content = View::factory('blocks/collection')
        ->bind('collection', $collection);
  
  return;
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
        
  	if (!$_FILES) return;
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
   if($files->check()) {
         //if passed checks save image in new home 
            $user_id=Auth::instance()->get_user();
            $album_id=$this->request->param('id');
            
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
		//STORE IMAGE IN DB	
		//Get filename and path parts	
		 
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
		  
		  $image=ORM::factory('image');
	      $image->values($record);
	      $image->check();
	      $image->save();
	      $image->add('albums', $album_id);

		  $return=$image->as_array();	
		  $return['status']=1;
		  
   } else {	 
		    $return = array(
			 'status' => '0',
			 'error' => "Upload and server side validation failed"
			);
   }
	
   if ($this->request->is_ajax() || Request::$user_agent=='Adobe Flash Player 10') {
      	    $this->auto_render = FALSE;
            $this->is_ajax = TRUE;
            header('content-type: application/json');
            $this->response->body( json_encode($return) );
    }
     $results="<pre>".print_r($return,true)."</pre>";
   
      
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
  	if ($_GET) {
  	  Switch ($_GET['mode']){
  	  	CASE 'swap':
  	  	  $a=ORM::factory('image',$_GET['a']);
  	  	  $b=ORM::factory('image',$_GET['b']);
  	  	  
  	  	  $temp=$a->order;
  	  	  
  	  	  $a->set('order',$b->order);
  	  	  $a->save();
  	  	  
  	  	  $b->set('order',$temp);
  	  	  $b->save();
  	  	  
  	  	  $this->request->redirect(Request::current()->uri());
  	  	break;	
  	  	CASE 'first':
  	  	  $order=2;
  	  	  foreach($images as $image) {
  	  	    if ($image->id==$_GET['image']) {
  	  	    
  	  	
  	  	      $image->set('order',1);
  	  	      echo 'image-'. $image->order;
  	  	      $image->save();
  	  	    } else {
  	  	      $image->set('order',$order++)->save();
  	  	    }
  	  	  }
  	  	break;
  	  	CASE 'last':
  	  	  $order=1;
  	  	  foreach($images as $image) {
  	  	    if ($image->id==$_GET['image']) {
  	  	echo 'hello-'.$images->count();
  	  	      $image->set('order',$images->count())->save();
  	  	    } else {
  	  	    $image->set('order',$order++)->save();
  	  	    }
  	  	  }
  	  	break;
  	  	CASE 'reorder':
  	  	  if (!is_array($array=$_GET['order'])) return;
  	  	    $sql="INSERT INTO `image` (`id`,`order`) VALUES ";
  	  	    foreach ($array as $order=>$id) {
  	  	      $sql.="($id,$order), " ;
  	  	    }
  	  	    $sql=trim($sql,', ')." ON DUPLICATE KEY UPDATE `order`=VALUES(`order`);";
        $this->_db->query(Database::INSERT, $sql, FALSE)->execute();
  	  	break;
  	    DEFAULT;
  	  	}
  	  	$this->request->redirect($this->request->uri());
  	}
  	
  }
  //public function action_delete(){}
}