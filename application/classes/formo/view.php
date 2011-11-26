<?php defined('SYSPATH') or die('No direct script access.');

 class Formo_View extends Formo_Core_View {
	/**
	 * Retrieve error
	 * 
	 * @access public
	 * @return mixed
	 */
	public function error()
	{
	  $replace="{$this->_field->message_file()}.{$this->_field->alias()}.";
	  $msg=str_replace($replace, '', $this->_field->error());
		return $msg;
	}
	
}