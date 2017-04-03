<?php
require_once 'utils/point2D.php';
require_once 'utils/databaseConnect.php';

class Pin
{
	public $id;
	public $name;
	public $pos = Point2D();
	public $mapId;

	public function getAllPaths()
	{
		// Pobiera wszystkie sciezki z danym pinem.
	}

	public function getPathToPin($pin)
	{
		// Pobiera (jezeli istnieje) sciezke do pinu z parametru.
	}
}

?>