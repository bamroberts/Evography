<?php
class Controller_Api_Album extends Controller_REST {
 
	// Output formats supported by this controller
	protected $supported_formats = array(
		'.xhtml',
		'.json',
		'.xml',
		'.rss',
	);
 
	
	function action_index(){
	  //if get limit set default
	  //set offset
	  //$albums=new Model_Albums($id);
	  $album=Orm::factory('album')->limit(5)->find_all()->as_array();
	  $this->response->body($this->_prepare_response($album));
	}
	
	function action_create(){}
	function action_update(){}
	function action_delete(){}
		
	
	 
	// Method to prepare the output
	protected function _prepare_response($messages,$format='json')
	{
		// Return messages formatted correctly to format
		switch ($format) {
			case 'json' : 
				$this->request->headers['Content-Type'] = 'application/json';
				//$data = $data->as_array();
				return json_encode($messages);
			
			case 'html' : 
				return View::factory('album/xhtml', $messages);
			
			default : 
				throw new Controller_Exception_404('File not found!');
		}	
		}
	}