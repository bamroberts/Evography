<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Abstract controller class for automatic templating.
 *
 * @package    Kohana
 * @category   Controller
 * @author     Kohana Team
 * @copyright  (c) 2008-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Controller_Template extends Kohana_Controller_Template {

	/**
	 * @var  View  page template
	 */
	public $base = 'templates';
	public $template = 'default';
		
	function getTemplate() {
		return Theme::factory($this->getViewPath($this->template));
	}
	
	function getTemplatePath() {
		return "{$this->base}/{$this->template}";
	}
	
	function getView($page, $data = null) {
		return Theme::factory($this->getViewPath($page), $data);
	}
	
	function getViewPath($page) {
		return "{$this->base}/$page";
	}

	/**
	 * Loads the template [View] object.
	 */
	public function before()
	{
		if ($this->auto_render === TRUE)
		{
			// Load the template
			$this->template = $this->getTemplate();
		}

		//return parent::before();
	}

} // End Controller_Template
