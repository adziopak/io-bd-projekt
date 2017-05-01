<?php

class BuildingFloor
{
	public $name;
	public $floor;

	public static function GetAll()
	{
		$floors = array();
		$floor = new BuildingFloor;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select buildings.name, maps.floor from buildings 
			left join maps on buildings.id = maps.building_id");
		$stmt->execute();

		$stmt->bind_result($floor->name, $floor->floor);

		while ($stmt->fetch())
		{
			$floorCloned = new BuildingFloor;
			$floorCloned->name = $floor->name;
			$floorCloned->floor=  $floor->floor;
			$floors[] = $floorCloned;
		}

		return $floors;
	}
}

?>