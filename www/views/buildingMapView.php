<?php

require_once 'utils/point2D.php';

class BuildingMapView
{
	public $currentMap;
	public $mapWidth;
	public $mapHeight;
	public $position = array();

	function render()
	{
		$pin = "<circle cx=\"::x::%\" cy=\"::y::%\" r=\"10\" stroke=\"black\" fill=\"red\" />";
		$pins = "";

		foreach ($this->position as $p)
			$pins = $pins . str_replace(["::x::", "::y::"], [$p->x, $p->y], $pin);

		$content = file_get_contents('views/buildingMapView.html');
		$content = str_replace([
			"::currentMap::",
			"::mapWidth::",
			"::mapHeight::",
			"::Pins::" 
		], [
			$this->currentMap,
			$this->mapWidth,
			$this->mapHeight,
			$pins
		], $content);
		return $content;
	}
}

?>