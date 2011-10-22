<?php
class Access {

static function permission($node) {
          if (is_string($node) || is_numeric($node)) {
            $node=Orm::factory('album',$node);
          }
          ($password=$node->password);
          if ($password->active){
              
              //do we have a session password for this password file (remember if might be inherited not just for this album) 
              if ($password->phrase!='' && md5($password->phrase) == Session::instance()->get("password_{$password->id}") ) {
                return true;
              }
              //if not are we logged in and have access
              if ($password->user_ids!='' 
               && Auth::instance()->get_user() 
               && stristr(",{$password->user_ids},", ",".Auth::instance()->get_user()->id."," ) 
              ) {
                return true;
              }
          return false;
          }
    }    
}