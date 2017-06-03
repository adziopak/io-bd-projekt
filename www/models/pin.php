<?php
require_once 'utils/databaseConnect.php';
require_once 'models/path.php';

class Pin
{
	public $id = null;
	public $name;
	public $posX;
	public $posY;
	public $mapId;
	public $adminId;

	public static function GetById($id)
	{
		$pin = new Pin;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from pins where id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$stmt->bind_result($pin->id, $pin->name, $pin->posX, $pin->posY, $pin->mapId, $pin->adminId);

		if ($stmt->fetch())
		{
			return $pin;
		}
		else 
		{
			return null;
		}
	}

	public static function GetByName($name)
	{
		$pins = array();
		$pin = new Pin;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from pins where name = ?");
		$stmt->bind_param("s", $name);
		$stmt->execute();

		$stmt->bind_result($pin->id, $pin->name, $pin->posX, $pin->posY, $pin->mapId, 
			$pin->adminId);

		while ($stmt->fetch())
		{			
			// Not so pretty
			$pinCloned = new Pin;
			$pinCloned->id = $pin->id;
			$pinCloned->name = $pin->name;
			$pinCloned->posX = $pin->posX;
			$pinCloned->posY = $pin->posY;
			$pinCloned->mapId = $pin->mapId;
			$pinCloned->adminId = $pin->adminId;
			$pins[] = $pinCloned;
		}

		return $pins;
	}

	public function getPaths()
	{
		$paths = array();
		$path = new path;
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from paths where first_pin_id = ? or second_pin_id = ?");
		$stmt->bind_param("ii", $this->id, $this->id);
		$stmt->execute();

		$stmt->bind_result($path->id, $path->firstPinId, $path->secondPinId, $path->adminId);

		while ($stmt->fetch())
		{
			$pathCloned = new Path;
			$pathCloned->id = $path->id;
			$pathCloned->firstPinId = $path->firstPinId;
			$pathCloned->secondPinId = $path->secondPinId;
			$pathCloned->adminId = $path->adminId;
			$paths[] =  $pathCloned;
		}

		return $paths;
	}

	public function update()
	{
		$dbconn = new DatabaseConnect;

		if ($this->id === null)
		{	
			$stmt = $dbconn->prepare("insert into pins (name, pos_x, pos_y, map_id, admin_id)
				values (?, ?, ?, ?, ?)");
			$stmt->bind_param("sddii", $this->name, $this->posX, $this->posY, $this->mapId,
				$this->adminId);

			if ($stmt->execute())
			{
				$this->id = $stmt->insert_id;
				return TRUE;
			}
			return FALSE;
		}
		else
		{
			$stmt = $dbconn->prepare("update maps set name = ?, pos_x = ?, pos_y = ?,
				map_id = ?, admin_id = ? where id = ?");
			$stmt->bind_param("sddii", $this->name, $this->posX, $this->posY, $this->mapId,
				$this->adminId, $this->id);
			return $stmt->execute();
		}
	}
}

?>