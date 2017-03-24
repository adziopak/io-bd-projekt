<?php

class BuildingMapView
{
	public $currentMap;

	function render()
	{
		$content = file_get_contents('views/buildingMapView.html');
		$content = str_replace("::currentMap::", $this->currentMap, $content);
		return $content;
	}
}

?>