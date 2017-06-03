<?php
require_once 'utils/databaseConnect.php';
require_once 'models/map.php';

class Building
{
	public $id = null;
	public $name;
	public $lat;
	public $lon;
	public $adminId;

	public static function GetById($id)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from buildings where id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$building = new Building;
		$stmt->bind_result($building->id, $building->name, $building->lat, $building->lon,
			$building->adminId);

		if ($stmt->fetch())
		{
			return $building;
		}
		else 
		{
			return null;
		}
	}

	public static function GetByName($name)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from buildings where name = ?");
		$stmt->bind_param("s", $name);
		$stmt->execute();

		$building = new Building;
		$stmt->bind_result($building->id, $building->name, $building->lat, $building->lon,
			$building->adminId);

		if ($stmt->fetch())
		{
			return $building;
		}
		else 
		{
			return null;
		}
	}

	public static function GetAll()
	{
		$buildings = array();
		$building = new Building;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from buildings");
		$stmt->execute();

		$stmt->bind_result($building->id, $building->name, $building->lat, $building->lon, 
			$building->adminId);

		while ($stmt->fetch())
		{			
			// Not so pretty
			$bCloned= new Building;
			$bCloned->id = $building->id;
			$bCloned->name = $building->name;
			$bCloned->lat = $building->lat;
			$bCloned->lon = $building->lon;
			$bCloned->adminId = $building->adminId;
			$buildings[] = $bCloned;
		}

		return $buildings;
	}

	public function getMap($floor)
	{
		$map = new Map;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from maps where building_id = ? and floor = ?");
		$stmt->bind_param("ii", $this->id, $floor);
		$stmt->execute();

		$stmt->bind_result($map->id, $map->floor, $map->image, $map->imageMD5, $map->imageWidth,
			$map->imageHeight, $map->buildingId, $map->adminId);

		if ($stmt->fetch())
		{
			return $map;
		}
		else 
		{
			return null;
		}
	}

	public function update()
	{
		$dbconn = new DatabaseConnect;

		if ($this->id === null)
		{	
			$stmt = $dbconn->prepare("insert into buildings (name, lat, lon, admin_id) 
				values (?, ?, ?, ?)");
			$stmt->bind_param("sssi", $this->name, $this->lat, $this->lon, $this->adminId);

			if ($stmt->execute())
			{
				$this->id = $stmt->insert_id;
				return TRUE;
			}
			return FALSE;
		}
		else
		{
			$stmt = $dbconn->prepare("update buildings set name = ?, lat = ?, 
				lon = ?, admin_id = ? where id = ?");
			$stmt->bind_param("sssii", $this->name, $this->lat, $this->lon, $this->adminId, 
				$this->id);

			return $stmt->execute();
		}
	}
}

?>