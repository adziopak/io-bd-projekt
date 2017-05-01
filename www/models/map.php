<?php
require_once 'utils/databaseConnect.php';
require_once 'models/pin.php';

class Map
{
	public $id = null;
	public $floor;
	public $image;
	public $imageMD5;
	public $imageWidth;
	public $imageHeight;
	public $buildingId;
	public $editorId;

	function __clone()
	{
		$this->id = clone $this->id;
		$this->floor = clone $this->floor;
		$this->image = clone $this->image;
		$this->imageMD5 = clone $this->imageMD5;
		$this->imageWidth = clone $this->imageWidth;
		$this->imageHeight = clone $this->imageHeight;
		$this->buildingId = clone $this->buildingId;
		$this->editorId = clone $this->editorId;
	}

	public static function GetById($id)
	{
		$map = new Map;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from maps where id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$stmt->bind_result($map->id, $map->floor, $map->image, $map->imageMD5, $map->imageWidth,
			$map->imageHeight, $map->buildingId, $map->editorId);

		if ($stmt->fetch())
		{
			return $map;
		}
		else 
		{
			return null;
		}
	}

	public function getPins()
	{
		$pins = array();
		$pin = new Pin;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from pins where map_id = ?");
		$stmt->bind_param("i", $this->id);
		$stmt->execute();

		$stmt->bind_result($pin->id, $pin->name, $pin->posX, $pin->posY, $pin->mapId, 
			$pin->editorId);

		while ($stmt->fetch())
		{			
			$pins[] = clone $pin;
		}

		return $pins;
	}

	public function getPinByName($pinName)
	{
		$pin = new Pin;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from pins where map_id = ? and name = ?");
		$stmt->bind_param("is", $this->id, $pinName);
		$stmt->execute();

		$stmt->bind_result($pin->id, $pin->name, $pin->posX, $pin->posY, $pin->mapId, 
			$pin->editorId);

		if ($stmt->fetch())
		{
			return $pin;
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
			$stmt = $dbconn->prepare("insert into maps (floor, image, image_md5, image_width,
				image_height, building_id, editor_id) values (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("issiiii", $this->floor, $this->image, $this->imageMD5, 
				$this->imageWidth, $this->imageHeight, $this->buildingId, $this->editor_id);

			return $stmt->execute();
		}
		else
		{
			$stmt = $dbconn->prepare("update maps set floor = ?, image = ?, image_md5 = ?, 
				image_width = ?, image_height = ?, buidling_id = ?, editor_id = ? where id = ?");
			$stmt->bind_param("issiiiii", $this->floor, $this->image, $this->imageMD5, 
				$this->imageWidth, $this->imageHeight, $this->buildingId, $this->editor_id,
				$this->id);

			return $stmt->execute();
		}
	}
}
?>