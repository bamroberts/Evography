<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Album extends Controller_Admin_Album_Core {
  protected $_fields=array('name', 'desc', 'published','comments','cart','facebook','private','theme','export','open');
  
  public function action_index(){    
      if ($id=$this->request->param('id')){
        $this->template->content = View::factory('/admin/album/summary')
            ->bind('album', $album);
            
        $album=Orm::factory($this->_model,$id);
      } else {
        $collections=ORM::factory($this->_model,$this->id)
          ->get_descendants(false,'ASC',False,false,false,array(array('column'=>'type','operator'=>'=','value'=>$this->request->controller())));
    
        $this->template->content=View::factory('/admin/blocks/collection')
          ->bind('collection',$collections);
      }    
  }
  
  
  
  public function action_upload(){
    $this->sub();
  }
  
  public function action_images(){
    $images=$this->node->images->find_all();
      $this->template->content = View::factory('admin/album/images')
                              ->set('images',$images);
  }
  

  
  
  function after(){
  
    if ($this->auto_render) {  
      $view=View::factory('admin/album')
         ->set('content',$this->template->content)
         ->set('album',$this->node);
      $this->template->content = $view;
    }
    
    parent::after();
  }
  
  public function action_edit(){
    $this->_fields[]='open';
    $this->_fields[]='cart';
    $this->_fields[]='comments';
    parent::action_edit();
    
  }
  
     
  
  public function action_organise(){
  	$album=$this->node;
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
      $album= $this->node
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