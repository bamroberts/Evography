<?php defined('SYSPATH') or die('No direct script access.');
class Controller_System_Router extends Master_Master {
  function action_index(){
    $domain=$_SERVER['HTTP_HOST'];
    //echo "$domain - ";
    $url=trim($this->request->url(),'/');    
    //echo debug::vars($this->request->param());
    //echo debug::vars($this->request->url());
    //die();
   echo $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    
       
   echo  Debug::Vars($_SERVER);
    //??Can we put page caching here?
    
    $domain=ORM::factory('domain',array('name'=>$domain));
    if (!$domain->id){
      $this->fof();
      //domain not found in our system, do you want to signup
    }
    $session=Session::instance();
    $session->set('root_node', $domain->node_id);
    
    $settings=array(
      'account' =>$domain->user->username,
      'rootnode'=>$domain->node_id,
      'node'    =>$domain->node_id,
      'theme'   =>$domain->theme_id,
      'controller'   =>$domain->node->type,
    );
    $this->user_id=$domain->user_id;
    $this->update_subscription_details();
    if(!$domain->user->account->active){
    //redirect to offline-
      
      $url='/offline';
    }
    
    if ($url){
    //This query will get the album from the full url path.
    $sql=" 
    SELECT * 
    FROM (
      SELECT a.*,
      (
        SELECT group_concat(at2.slug ORDER BY at2.level ASC SEPARATOR '/') 
        FROM album_tree at2 
        WHERE at2.lft <= a.lft 
        AND at2.rgt >= a.rgt
        AND at2.lft > (SELECT lft FROM album_tree WHERE id ='$domain->node_id')
        AND at2.rgt < (SELECT rgt FROM album_tree WHERE id ='$domain->node_id')
      ) path
      FROM album_tree a
      ) temp_table
    WHERE '$url' like concat(path,'%')
    ORDER BY length(path) DESC
    LIMIT 1
    " ;
    $query=DB::query(Database::SELECT,$sql)->as_object()->execute();
    $album=$query->current();
    if (! $album){
      echo $sql;
        $this->fof(); // url not found
    }
      $settings['node']=$album->id;
      $settings['controller']=$album->type;
      
      $path=$album->path;
      $null='';
      $cound=1;
      $url=str_replace($path, $null,$url , $count);
    }
    
    
      $path=Route::get('CLEANROUTE')->uri($settings)."$url";
      //echo $path; die();
      //$this->request->body( 
      //echo $path;
      //echo Request::factory($path)->execute();
      $this->auto_render=false;
      
      $this->response->headers('cache-control', 'public, max-age=3600');
      $this->template->content=Request::factory($path, Cache::instance('file'))->execute();
      
      $this->response->body( $this->template->content );
      

    
    //$route="r/$theme/$album->id/$action";
  /*  
    gallery.rocomanda.com = startnode 1
    alecmaxwell.rocomanda.com startnode 15
    
    xxx-### = query pair
    xxx--xxx = controller action pair
    /###/ = id
    
    page-2
    image-delete
    -delete = current controller
    
    -image/17
    
    /weddings/2011/bryony-and-luke/
    
    /weddings/2011/bryony-and-luke/page-2/
    /weddings/2011/bryony-and-luke/buy/image-17/
    /weddings/2011/bryony-and-luke/comment-add/image-17
    /weddings/2011/bryony-and-luke/comment/image-17/add/
    
    
    /weddings/2011/bryony-and-luke/main-album/buy/image-17/
    album_id must be within master_node - set by domain
    
    /album_id/controller/id/action
    
    */

  }
  
  
  
}