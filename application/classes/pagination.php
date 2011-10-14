<?php 
defined('SYSPATH') or die('No direct script access.');

class Pagination extends Kohana_pagination {

  //This uses request::initial() rather than request::current() for URL's, needed if you are doing sub-requests or Hmvc.
  public function url($page = 1)
  	{
  		// Clean the page number
  		$page = max(1, (int) $page);
  
  		// No page number in URLs to first page
  		if ($page === 1 AND ! $this->config['first_page_in_url'])
  		{
  			$page = NULL;
  		}
      
      
  		switch ($this->config['current_page']['source'])
  		{
  			case 'query_string':
  				return URL::site(Request::current()->uri()).URL::query(array($this->config['current_page']['key'] => $page));
  
  			case 'route':
  				return URL::site(Request::current()->uri(array($this->config['current_page']['key'] => $page))).URL::query();
  		}
  
  		return '#';
  	}
  	
  	//if we override perpage with 0, it will display all results 
  	public function setup(array $config = array()){
  	  if (Arr::get($config,'items_per_page')==0 && $total=Arr::get($config,'total_items')){
  	    $config['items_per_page']=$total;
  	  }
  	  return parent::setup($config);
  	}
}