<?php 
defined('SYSPATH') or die('No direct script access.');

return array(
    'username' => array(
        'not_empty' => 'You must enter a field.',
        'min_length'    => ':field must be at least :param2 characters long',
      	'max_length'    => ':field must not exceed :param2 characters long',
        'username_available' => 'The username you are entering has already been taken.',
    ),
    'email' => array(
        'not_empty' => 'You must enter an email address.',
        'min_length'    => ':field must be at least :param2 characters long',
      	'max_length'    => ':field must not exceed :param2 characters long',
        'email'=>'This must be a valid email address.',
        'email_available' => 'This email address is already registered to an existing account.',
    ),
    'password' => array(
        'not_empty' => 'You must enter a :field.',
        'min_length' =>':field must be at least :param2 characters long',
    )
    
);