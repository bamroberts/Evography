<?php 
class Controller_Admin_UploadFacebook extends Controller_Admin_Upload {
  protected $source='facebook';
    
  protected $model = array(
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
  );
    
  public function before(){
    parent::before();
    if (! $this->facebook=Facebook::factory() )
    {
      $this->request->action('login');
    }
  }  
    
  public function action_albums(){
    $this->template->content=$this->get_albums();
  }
  
  public function action_images(){
    $this->template->content=$this->get_album_images();
  }
  
  public function action_index(){
    $this->template->content = $this->getView('facebook/import')//View::factory('admin/facebook/import')
      ->set('user'  ,  $this->facebook->user()    )
      ->set('albums',  $this->get_albums()        )
      ->set('images',  $this->get_album_images()  );
  }
  
  public function action_login(){
    $this->template->content = Facebook::login();
  }

  public function get_albums(){
    $columns=$this->model;
    $albums = $this->facebook->get('/me/albums?limit=0');
    
    foreach ($albums['data'] as $key=>$album) {
      $columns['album']['options'][$album['id']]="{$album['name']} - ". Arr::get($album,'count',0)." images";
    }
  
    $post=$this->request->initial()->post();
    
    return $this->getView('facebook/albums')//View::factory('admin/facebook/albums')
      ->bind('columns',$columns)    
      ->bind('data',$post)
      ->bind('errors',$errors);
  }
  
  public function get_album_images(){
    $post=$this->request->initial()->post();
    //If no album is selected return 
    if ( ! $album_id = Arr::get($post,'album')) return;
    
    $columns=$this->model; 
           
    $images = $this->facebook->get("/{$album_id}/photos/?fields=id,picture,images,from&limit=0");
    
    foreach ($images['data'] as $key=>$image) {
      $columns['images']['options'][$key]=Arr::get($image,'picture',0);
    }
       
    //import is set, import selected images
    if (is_array($import=Arr::get($post,'images',false) ) ) 
    {
      $image=$images['data'];
      unset($_POST['images']);
      
      $user_id=$this->user_id;
      $album_id=$this->request->param('id');
      $path = DOCROOT."images/uploads/{$user_id}/{$album_id}/";
		  if (!is_dir($path)) {
		   mkdir($path,0777,true);
		  }
      
      foreach ($import as $id=>$tick) {
        $remote=$image[$id]['images'][0]['source'];
        $file=pathinfo($remote);	
			  $new_filename = uniqid().'.'.strtolower($file['extension']);
			  
        $get=file_get_contents($remote);
        $put=file_put_contents($path.$new_filename,$get);
        $filepath=$path.$new_filename; 
        $this->save($filepath);
      }
    }
      
    return $this->getView('facebook/images')//View::factory('admin/facebook/images')
          ->bind('album',$album_id  )
          ->bind('columns',$columns)
          ->bind('data',$post)
          ->bind('errors',$errors)
          ;
    }
}