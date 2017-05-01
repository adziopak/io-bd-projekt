<?php
require_once 'utils/databaseConnect.php';
require_once 'models/pin.php';

class PathCoords
{
	public $posX1;
	public $posY1;
	public $posX2;
	public $posY2;

	public static function GetAllFromMapId($id)
	{
		$paths = array();
		$path = new PathCoords;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select p1.pos_x, p1.pos_y, p2.pos_x, p2.pos_y from paths
		 	left join pins p1 on paths.first_pin_id = p1.id
		 	left join pins p2 on paths.second_pin_id = p2.id
		 	where p1.map_id = ? and p2.map_id = ?");
		$stmt->bind_param("ii", $id, $id);
		$stmt->execute();

		$stmt->bind_result($path->posX1, $path->posY1, $path->posX2, $path->posY2);

		while ($stmt->fetch())
		{			
			// Not so pretty
			$pathCloned = new PathCoords;
			$pathCloned->posX1 = $path->posX1;
			$pathCloned->posY1 = $path->posY1;
			$pathCloned->posX2 = $path->posX2;
			$pathCloned->posY2 = $path->posY2;
			$paths[] = $pathCloned;
		}

		return $paths;
	}
}


?>