<?php 
defined('SYSPATH') or die('No direct script access.');

return array(
    'name' => array(
        'not_empty' => 'You must enter a field.',
        'min_length'    => ':field must be at least :param2 characters long',
      	'max_length'    => ':field must not exceed :param2 characters long',
        'domain_available' => 'This domain is already in use within our system.',
        'domain_valid' => 'It appears that you have entered an invalid domain name.',
        'domain_protected' => 'Sorry that domain name is not available for use.',
        'domain_sub' => 'Sorry you are only allowed one sub-domain of '. $_SERVER['HTTP_HOST'] .'. You are however allowed sub-sub domains e.g. sub1.mysub.'. $_SERVER['HTTP_HOST'],
    ),
    'node_id' => array(
        'not_empty' => 'You must pick a starting point.',    
    )
    
);