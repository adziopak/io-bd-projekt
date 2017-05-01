<?php
require_once 'models/map.php';
require_once 'models/pin.php';

class BuildingShowView
{
	public $map;
	public $pins = array();
	public $paths = array();

	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$css = file_get_contents('views/building/showView.css');
		$body = file_get_contents('views/building/showView.html');
		$pin = file_get_contents('views/_pinView.html');
		$path = file_get_contents('views/_pathView.html');
		$pins = '';
		$paths = '';
		
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::'],
			[$css, $body, ''], $layout);

		foreach ($this->pins as $p)
			$pins = $pins . str_replace(["::id::", "::x::", "::y::"], 
				[$p->id, $p->posX, $p->posY], $pin);

		foreach ($this->paths as $p)
			$paths = $paths . str_replace(['::x1::', '::y1::', '::x2::', '::y2::'],
				[$p->posX1, $p->posY1, $p->posX2, $p->posY2], $path);

		$content = str_replace(['::pins::', '::paths::', '::image::'], 
			[$pins, $paths, $this->map->image], $content);

		return $content;
	}
}

?>