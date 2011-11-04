<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/London');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	  'base_url'      => '/', 
    'index_file'    => FALSE, 
    'errors'        => (Kohana::$environment == Kohana::DEVELOPMENT), 
    'profile'       => (Kohana::$environment == Kohana::DEVELOPMENT), 
    'caching'       => (Kohana::$environment == Kohana::PRODUCTION)  
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	 'auth'       => MODPATH.'auth',       // Basic authentication
	 'cache'      => MODPATH.'cache',      // Caching with multiple backends
   'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	  // 'unittest'   => MODPATH.'unittest',   // Unit testing
	  // 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	  'hint' => MODPATH.'hint', // Light "flash" messages
    'mailer' => MODPATH.'mailer', // Mail functions
    'orm-tree' => MODPATH.'orm-tree', // Tree based ORM
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
 	$route_conditions = array('id'=>'[a-zA-Z0-9_-]+','width'=>'[0-9]+','height'=>'[0-9]+','mode'=>'crop|fit|stretch|width|height|flex','pin'=>'-tl|-t|-tr|-r|-br|-b|-bl|-l|-c','format'=>'jpg|png|gif');
	ROUTE::set('image', 'images/dynamic/(<id>)(/<width>x<height>(x<mode>(<pin>)).<format>)',$route_conditions)
  ->defaults(array(
    'directory'  => 'system',
    'controller' => 'dynamicimage',
    'action'     => 'index',
    'id'         => null,
	  'width'      => 100,
	  'height'     => 100,
	  'mode'       => 'fit',
	  'format'     => 'jpg',
	  'pin'        => ''
  ));
  
  $route_conditions = array('action'=>'[a-zA-Z_-]+[0-9]*[a-zA-Z_-]*','subaction'=>'[a-zA-Z_-]+[0-9]*[a-zA-Z_-]*','format'=>'part|ajax|xml|json|result','id'=>'[0-9]+','name'=>'[a-zA-Zs]+');
     
     ROUTE::set('admin', 'admin(/<controller>(/<id>)(/<action>)(/<subaction>)(/<name>))(.<format>)',$route_conditions)
  ->defaults(array(
    'directory'  => 'admin',
    'controller' => 'user',
    'action'     => 'index',
    'subaction'  => 'index',
    'id'         => null,
    'name'       => null,
    'format'     => false,
  ));
    
  //get domain based routes  
  Route::domain(); 
    
    
  if ($_SERVER['HTTP_HOST']=='evography.com'||$_SERVER['HTTP_HOST']=='evography.dev')  {
  //If we are on www.
    $route_conditions = array('action'=>'[a-zA-Z_-]*[a-zA-Z_-]*','format'=>'html|xml|json|result','id'=>'[0-9]+','name'=>'[a-zA-Zs+-]+');
    Route::set('site', '(<action>)(/<id>(-<name>))(.<format>)',$route_conditions)
  	->defaults(array(
  	  'user' => '',
      'directory'  => 'site',
  		'controller' => 'home',
  		'action'     => 'index',	
  	  'format'     => null,
  	  'id'         => null,
  	  'name'       => null,
  	));
  }
  
  //catch all - unknown domain 
  Route::set('unknown-domain', '(<url>)')
	->defaults(array(
	  'user' => '',
    'directory'  => 'site',
		'controller' => 'home',
		'action'     => 'unknown',	
	  'domain'     => $_SERVER['HTTP_HOST'],
	));
  

 // echo debug::vars(Route::all());
