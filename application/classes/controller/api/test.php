
<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_API_Test extends Controller_API
{

  function get(){
    $get=$this->request->get();
    $limit= Arr::get($get,'limit',10);
    $page = Arr::get($get,'start',1);
    
    $album=ORM::Factory('album');
    $total=$album->count_all();
    
    
    
	  $count=$this->node->images->count_all();
	  $pagination=Pagination::factory(
  	           array(
                  'total_items'    => $count,
                  'items_per_page' => $limit,
                  'item_type'      => 'album',
                  )
                );
    $this->_response_metadata += array(
            'sample' => 'data'
        );
 
        /**
         * The main API response
         */
        $this->_response_payload = $album
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all()
            ->as_array();	
            
      $this->_response_links += array(
            'create' => $this->_generate_link('POST',   '/api/jobs'),
            'next' =>   $this->_generate_link('GET',   '/api/jobs',array(
                'page' => 'next',
            )),
            'read'   => $this->_generate_link('GET',    '/api/jobs/:id', array(
                ':id' => 'id',
            )),
            'update' => $this->_generate_link('PUT',    '/api/jobs/:id', array(
                ':id' => 'id',
            )),
            'delete' => $this->_generate_link('DELETE', '/api/jobs/:id', array(
                ':id' => 'id',
            )),
            'owner'   => $this->_generate_link('GET',   '/api/user/:id', array(
                ':id' => 'id',
            )),
        );      
  }

}