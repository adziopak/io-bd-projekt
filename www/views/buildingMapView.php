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
		echo json_encode($this->position);

		$pin = "<circle cx=\"::x::%\" cy=\"::y::%\" r=\"10\" stroke=\"black\" fill=\"red\" />";
		$pins = "";

		foreach ($this->position as $p)
			$pins = $pins . str_replace(["::x::", "::y::"], [$p->x * 100, $p->y * 100], $pin);

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