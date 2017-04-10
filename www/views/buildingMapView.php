<?php

require_once 'utils/point2D.php';

class BuildingMapView
{
	public $currentMap;
	public $mapWidth;
	public $mapHeight;
	public $positions = array();
	public $maps = array();

	function render()
	{
		$pin = "<circle cx=\"::x::%\" cy=\"::y::%\" r=\"10\" stroke=\"black\" fill=\"red\" />";
		$pins = "";

		foreach ($this->positions as $p)
			$pins = $pins . str_replace(["::x::", "::y::"], [$p->x, $p->y], $pin);

		$mapOption = "<option value=\"::opt::\">::opt::</option>";
		$mapOptions = "";

		foreach ($this->maps as $m)
			$mapOptions = $mapOptions . str_replace(["::opt::"], [$m[0]], $mapOption);

		$content = file_get_contents('views/buildingMapView.html');
		$content = str_replace([
			"::currentMap::",
			"::mapWidth::",
			"::mapHeight::",
			"::Pins::",
			"::MapOptions::" 
		], [
			$this->currentMap,
			$this->mapWidth,
			$this->mapHeight,
			$pins,
			$mapOptions
		], $content);
		return $content;
	}
}

?>