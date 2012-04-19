<?php

$domain=$_SERVER['HTTP_HOST'];
$domain=ORM::factory('domain',array('name'=>$domain));

if ($domain->id){
  
    //route mapping
    $route_conditions = array(
      'controller'=>'[a-zA-Z_-]*[a-zA-Z_-]*',
      'action'=>'[a-zA-Z_-]*[a-zA-Z_-]*',
      'format'=>'html|part|xml|json|jpg',
      'id'=>'[0-9]+',
      'name'=>'[a-zA-Zs+-]+'
    );
    
    //Domain based defaults 
    $settings=array(
      'directory'  => 'gallery',
      'rootnode'  => $domain->node_id,
      'theme'     => $domain->theme_id,
      'format'     => '/',
      'id'         => null,
    );
    
    //Home route for domain
    Route::set("album_{$domain->node_id}", '(/<controller>(/<action>)(/<id>(-<name>)))(.<format>)',$route_conditions)
    ->defaults( $settings +
      array (
          'node'      => $domain->node_id,
          'controller'=> $domain->node->type,
          'action'    => $domain->node->style->name,
	     )
	   );

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
  ";
  
    //Available routes for this domain
    foreach ($routes as $route) {
      Route::set("album_{$route->id}", "{$route->path}(/<controller>(/<action>)(/<id>(-<name>)))<format>",$route_conditions)
        ->defaults( $settings +
          array (
            'node'       => $route->node,
    		    'controller' => $route->type,
    		    'action'     => $route->style,	
	        )
	      );
    }
}
