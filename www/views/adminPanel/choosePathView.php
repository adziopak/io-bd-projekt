<?php
require_once 'models/buildingFloor.php';

class choosePathView
{
	public $floors = array();

	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$js = file_get_contents('views/adminPanel/choosePathView.js');
		$body = file_get_contents('views/adminPanel/choosePathView.html');
				
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::', 
			'::RenderScriptsInclude::'],
			['', $body, $js, ''], $layout);

		$content = str_replace(['::jsMaps::'], [json_encode($this->floors)], $content);
		return $content;
	}
}

?>