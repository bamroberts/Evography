<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SwiftMailer transports
 *
 * @see http://swiftmailer.org/docs/transport-types
 *
 * Valid transports are: smtp, native, sendmail
 *
 * To use secure connections with SMTP, set "port" to 465 instead of 25.
 * To enable TLS, set "encryption" to "tls".
 * To enable SSL, set "encryption" to "ssl".
 *
 * Transport options:
 * @param   null  	native: no options
 * @param   string  sendmail: 
 * @param   array   smtp: hostname, username, password, port, encryption (optional)
 *
 */

return array
(
'default' => array(
	'transport'	=> 'smtp',
	'options'	=> array
					(
						'hostname'	=> 's33049.gridserver.com',
						'username'	=> 'info@alecmaxwell.com',
						'password'	=> '1emoncurd',
						'port'		  => '465',
					  'encryption'=> 'ssl'
					),
 ),
'production' => array(
	'transport'	=> 'smtp',
	'options'	=> array
					(
						'hostname'	=> 's33049.gridserver.com',
						'username'	=> 'info@alecmaxwell.com',
						'password'	=> '1emoncurd',
						'port'		  => '465',
					  'encryption'=> 'ssl'
					),
 ),
);
