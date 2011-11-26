<?php 
defined('SYSPATH') or die('No direct script access.');

return array(
    
    'email' => array(
        'not_empty' => 'You must enter an email address.',
        'min_length'    => ':field must be at least :param2 characters long',
      	'max_length'    => ':field must not exceed :param2 characters long',
        'email'=>'This must be a valid email address.',
        'email_available' => 'We already have your email address on record. Don\'t worry we\'ll be in touh soon. ',
    ),
    'name' => array(
        'not_empty' => 'You must enter a :field.',
        'min_length' =>'Your name should be at least :param2 characters long',
    )
    
);