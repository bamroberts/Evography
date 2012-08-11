<?php 
defined('SYSPATH') or die('No direct script access.');

class Route extends Kohana_route {

private $trail_slash=true;

public static function exists($name){
    return isset(Route::$_routes[$name]);
}

static function inject( $routes=array() ){
    Route::$_routes=Arr::merge(Route::$_routes,$routes);
}

//function to get and cache long nested slugs routes.
static function domain($domain=null) {
    $domain=($domain)?$domain:$_SERVER['HTTP_HOST'];
    $cache="{$domain}_routes";
//if ($routes=CASHE::get($cache)) {
    $domain=ORM::factory('domain',array('name'=>$domain));
    
    if (!$domain->id) return;
      
        //route mapping
        $route_conditions = array(
          'controller'  =>'[a-zA-Z_-]*[a-zA-Z_-]*',
          'action'      =>'[a-zA-Z_-]*[a-zA-Z_-]*',
          'format'      =>'html|part|ajax|json|jpg',
          'id'          =>'[0-9]+',
          'page'        =>'[0-9]+',
          'name'        =>'[a-zA-Zs+-]+'
        );
        $route_options="(/<controller>(/<action>)(/<id>(-<name>)))(/page-<page>)(.<format>)";
        
        //Domain based defaults 
        $settings=array(
          'directory'  => 'gallery',
          'user'       => $domain->user_id,
          'root'   => $domain->node_id,
          'theme'      => $domain->theme_id,
          'format'     => false,
          'id'         => null,
          'page'       => 1
        );
      
      //Get available album paths from DB  
      $sql="
          SELECT a.id, a.type, s.name as style,
          (
            SELECT group_concat(at2.slug ORDER BY at2.level ASC SEPARATOR '/') 
            FROM album_tree at2 
            WHERE at2.lft <= a.lft 
            AND at2.rgt >= a.rgt
            AND at2.lft > (SELECT lft FROM album_tree WHERE id ='$domain->node_id')
            AND at2.rgt < (SELECT rgt FROM album_tree WHERE id ='$domain->node_id')
          ) as path
          FROM album_tree a
          LEFT JOIN styles s on s.id = a.style_id
          WHERE lft > (SELECT lft FROM album_tree WHERE id ='$domain->node_id')
            AND a.rgt < (SELECT rgt FROM album_tree WHERE id ='$domain->node_id')
         ORDER BY a.level DESC
      ";
      $query=DB::query(Database::SELECT,$sql)->as_object()->execute();
      while ($route=$query->current()) {
         
        // echo "<pre>{$route->path}$route_options</pre>";
         $routes[$route->id] = new Route("{$route->path}$route_options", $route_conditions);
         $routes[$route->id]
           ->defaults( $settings +
              array (
                'node'       => $route->id,
        		    'controller' => $route->type,
        		    'action'     => $route->style,
        		    'root'       => false,	
    	        )
    	      );
    	      
    	  $query->next();    
        }
        
        //echo $domain->node_id;
        //Add default path for domain
        //options are duplicated as they need the first / removed
        $route_options="(index)(<controller>(/<action>)(/<id>(-<name>)))(/page-<page>)(.<format>)";
        $routes[$domain->node_id] = new Route("$route_options", $route_conditions);
        $routes[$domain->node_id]
           ->defaults( $settings +
              array (
                'node'      => $domain->node_id,
                'controller'=> $domain->node->type,
                'action'    => $domain->node->style->name,
                'root'      => true,	
    	        )
    	      );
    	  
    	 $routes['not-found'] = new Route("<path>",array('path' => '.*'));
        $routes['not-found']
          ->defaults( $settings +
              array (
                'node'      => $domain->node_id,
                'controller'=> 'static',
                'action'    => '404',
    	        )
    	      );
    	 //     Route::set('static', '<path>', array('path' => '.*'))->defaults( $settings +
         //     array (
         //       'node'      => $domain->node_id,
        //        'controller'=> 'static',
        //        'action'    => '404',
    	   //     )
    	   //   );
     // Cashe::save($cache)  } 
     
     //inject routes
        Route::inject($routes);
  }
  
  public function get_default($param){
    return Arr::get($this->_defaults,$param,false);
  }
  
  //Copy of normal reverse route, but set to ignore defaults 
  public function uri(array $params = NULL)
    {
    // Start with the routed URI
    $uri = $this->_uri;
 
    if (strpos($uri, '<') === FALSE AND strpos($uri, '(') === FALSE)
    {
        // This is a static route, no need to replace anything
 
        if ( ! $this->is_external())
            return $uri;
 
        // If the localhost setting does not have a protocol
        if (strpos($this->_defaults['host'], '://') === FALSE)
        {
            // Use the default defined protocol
            $params['host'] = Route::$default_protocol.$this->_defaults['host'];
        }
        else
        {
            // Use the supplied host with protocol
            $params['host'] = $this->_defaults['host'];
        }
 
        // Compile the final uri and return it
        return rtrim($params['host'], '/').'/'.$uri;
    }
 
    while (preg_match('#\([^()]++\)#', $uri, $match))
    {
        // Search for the matched value
        $search = $match[0];
 
        // Remove the parenthesis from the match as the replace
        $replace = substr($match[0], 1, -1);
 
        while (preg_match('#'.Route::REGEX_KEY.'#', $replace, $match))
        {
            list($key, $param) = $match;
 
            if (isset($params[$param]))
            {
                // Replace the key with the parameter value
                //$replace = str_replace($key, $params[$param], $replace);
                
                //chaned line to remove defaults
                $replace = (isset($this->_defaults[$param]) && $params[$param]==$this->_defaults[$param])?'':str_replace($key, $params[$param], $replace);
                
            }
            else
            {
                // This group has missing parameters
                $replace = '';
                break;
            }
        }
 
        // Replace the group in the URI
        $uri = str_replace($search, $replace, $uri);
    }
 
    while (preg_match('#'.Route::REGEX_KEY.'#', $uri, $match))
    {
        list($key, $param) = $match;
 
        if ( ! isset($params[$param]))
        {
            // Look for a default
            if (isset($this->_defaults[$param]))
            {
                $params[$param] = $this->_defaults[$param];
            }
            else
            {
                // Ungrouped parameters are required
                throw new Kohana_Exception('Required route parameter not passed: :param', array(
                    ':param' => $param,
                ));
        }
        }
 
        $uri = str_replace($key, $params[$param], $uri);
    }
 
    // Trim all extra slashes from the URI
    $uri = preg_replace('#//+#', '/', rtrim($uri, '/'));
 
    if ($this->is_external())
    {
        // Need to add the host to the URI
        $host = $this->_defaults['host'];
 
        if (strpos($host, '://') === FALSE)
        {
            // Use the default defined protocol
            $host = Route::$default_protocol.$host;
        }
 
        // Clean up the host and prepend it to the URI
        $uri = rtrim($host, '/').'/'.$uri;
    }
    
    return $uri;
  }
}