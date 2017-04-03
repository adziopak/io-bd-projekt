<?php
require_once 'utils/databaseConnect.php';
require_once 'utils/point2D.php';
require_once 'models/pin.php'

class Map
{
	public $id;
	public $name;
	public $image;
	public $width;
	public $height;

	public static function GetMapByName($mapName)
	{
		// Zwracanie mapki z bazy danych
	}

	public function getAllPins()
	{
		// Zwracanie wszyskich pinów z bazy danych na danej mapce
	}

	public function getPinByName($pinName)
	{
		// Zwracanie określonego pinu z bazy na danej mapce
	}
}
?>