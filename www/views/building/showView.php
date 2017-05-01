<?php
require_once 'models/map.php';
require_once 'models/pin.php';

class BuildingShowView
{
	public $map;
	public $pins = array();

	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$css = file_get_contents('views/building/showView.css');
		$body = file_get_contents('views/building/showView.html');
		$pin = file_get_contents('views/_pinView.html');
		$pins = '';
		
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::'],
			[$css, $body, ''], $layout);

		foreach ($this->pins as $p)
			$pins = $pins . str_replace(["::id::", "::x::", "::y::"], 
				[$p->id, $p->posX, $p->posY], $pin);

		$content = str_replace(["::pins::", "::image::"], 
			[$pins,	$this->map->image], $content);

		return $content;
	}
}

?>