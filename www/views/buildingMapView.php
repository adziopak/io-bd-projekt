<?php

class BuildingMapView
{
	public $currentMap;
	public $mapWidth;
	public $mapHeight;
	public $xPosition;
	public $yPositon;

	function render()
	{
		$content = file_get_contents('views/buildingMapView.html');
		$content = str_replace([
			"::currentMap::",
			"::mapWidth::",
			"::mapHeight::",
			"::xPosition::",
			"::yPosition::" 
		], [
			$this->currentMap,
			$this->mapWidth,
			$this->mapHeight,
			$this->xPosition,
			$this->yPosition
		], $content);
		return $content;
	}
}

?>