<?php
require_once 'utils/databaseConnect.php';
require_once 'models/pin.php';

class Path
{
	public $id = null;
	public $firstPinId;
	public $secondPinId;
	public $editorId;

	function __clone()
	{
		$this->id = clone $this->id;
		$this->firstPinId = clone $this->firstPinId;
		$this->secondPinId = clone $this->secondPinId;
		$this->editorId = clone $this->editorId;
	}

	public function getLength()
	{
		$firstPin = Pin::GetById($this->firstPinId);
		$secondPin = Pin::GetById($this->secondPinId);
		$vecX = $secondPin->posX - $firstPin->posX;
		$vecY = $secondPin->posY - $firstPin->posY;

		return sqrt($vecX * $vecX + $vecY * $vecY);
	}

	public function update()
	{
		$dbconn = new DatabaseConnect;

		if ($this->id === null)
		{	
			$stmt = $dbconn->prepare("insert into paths (first_pin_id, second_pin_id, editor_id)
				values (?, ?, ?)");
			$stmt->bind_param("iii", $this->firstPinId, $this->secondPinId, $this->editor_id);

			return $stmt->execute();
		}
		else
		{
			$stmt = $dbconn->prepare("update maps set first_pin_id = ?, second_pin_id = ?, 
				editor_id = ? where id = ?");
			$stmt->bind_param("iiii", $this->firstPinId, $this->secondPinId, $this->editor_id,
				$this->id);

			return $stmt->execute();
		}
	}
}


?>