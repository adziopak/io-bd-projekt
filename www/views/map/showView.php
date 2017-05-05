<?php
require_once 'models/building.php';

class MapShowView
{
	public $buildings = array();

	function render()
	{
		$config = file_get_contents('config/googleApiConfig.json');
		$config = json_decode($config, true);

		$layout = file_get_contents('views/_layoutView.html');
		$js = file_get_contents('views/map/showView.js');
		$css = file_get_contents('views/map/showView.css');
		$body = file_get_contents('views/map/showView.html');
		$jsInclude = '<script src="https://maps.googleapis.com/maps/api/js?key=' . 
			$config['apiKey'] . '&callback=initMap"></script>';


		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::', 
			'::RenderScriptsInclude::'],
			[$css, $body, $js, $jsInclude], $layout);

		$content = str_replace(['::jsBuildings::'], [json_encode($this->buildings)], $content);

		return $content;
	}
}

?>