<?php defined('SYSPATH') or die('No direct access allowed.');

$db = array
(
  'live' => array
  (
    'type'       => 'mysql',
    'connection' => array(
      /**
       * The following options are available for MySQL:
       *
       * string   hostname
       * string   username
       * string   password
       * boolean  persistent
       * string   database
       *
       * Ports and sockets may be appended to the hostname.
       */
      'hostname'   => 'internal-db.s33049.gridserver.com',
      'username'   => 'db33049_gallery',
      'password'   => 'jec!ech3',
      'persistent' => FALSE,
      'database'   => 'db33049_gallery',
    ),
    'table_prefix' => '',
    'charset'      => 'utf8',
    'caching'      => FALSE,
    'profiling'    => TRUE,
  ),
  'localhost' => array(
    'type'       => 'mysql',
    'connection' => array(
      /**
       * The following options are available for MySQL:
       *
       * string   hostname
       * string   username
       * string   password
       * boolean  persistent
       * string   database
       *
       * Ports and sockets may be appended to the hostname.
       */
      'hostname'   => 'localhost',
      'username'   => 'root',
      'password'   => 'break010',
      'persistent' => FALSE,
      'database'   => 'gallery',
    ),
    'table_prefix' => '',
    'charset'      => 'utf8',
    'caching'      => FALSE,
    'profiling'    => TRUE,
  ),
);

if(stristr($_SERVER['HTTP_HOST'],'.dev') ) {
  $db['default']=$db['localhost'];
} else {
  $db['default']=$db['live'];
}

return $db;
