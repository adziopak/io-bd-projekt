<?php
require_once 'models/buildingFloor.php';

class BuildingChooseView
{
	public $floors = array();

	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$js = file_get_contents('views/building/chooseView.js');
		$body = file_get_contents('views/building/chooseView.html');
				
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::', 
			'::RenderScriptsInclude::'],
			['', $body, $js, ''], $layout);

		$content = str_replace(['::jsMaps::'], [json_encode($this->floors)], $content);
		return $content;
	}
}

?>