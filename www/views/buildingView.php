<?php

require_once 'utils/point2D.php';

class BuildingView
{
	public $currentMap;
	public $mapWidth;
	public $mapHeight;
	public $positions = array();
	public $maps;

	function render()
	{
		$pin = "<circle cx=\"::x::%\" cy=\"::y::%\" r=\"10\" stroke=\"black\" fill=\"red\" />";
		$pins = "";

		foreach ($this->positions as $p)
			$pins = $pins . str_replace(["::x::", "::y::"], [$p->x, $p->y], $pin);

		$content = file_get_contents('views/buildingView.html');
		$content = str_replace([
			"::currentMap::",
			"::mapWidth::",
			"::mapHeight::",
			"::Pins::",
			"::JSMaps::" 
		], [
			$this->currentMap,
			$this->mapWidth,
			$this->mapHeight,
			$pins,
			$this->maps
		], $content);
		return $content;
	}
}

?>