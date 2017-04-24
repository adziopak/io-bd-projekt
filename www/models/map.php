<?php
require_once 'utils/databaseConnect.php';
require_once 'models/building.php';
require_once 'models/editor.php';

class Map
{
	public $id;
	public $floor;
	public $image;
	public $imageMD5;
	public $imageWidth;
	public $imageHeight;
	public $buildingId;
	public $editorId;

	public static function GetMapByName($mapName)
	{
		// Zwracanie mapki z bazy danych
	}

	public static function GetMapsNames()
	{
		// Zwracanie wszystkich nazw map z bazy danych
	}

	public function getPinsId()
	{
		// Zwracanie wszyskich pinów z bazy danych na danej mapce
	}

	public function getPinIdByName($pinName)
	{
		// Zwracanie określonego pinu z bazy na danej mapce
	}

	public function update()
	{
		
	}
}
?>