<?php
require_once 'utils/databaseConnect.php';

class Editor
{
	public $id = null;
	public $userName;
	public $userPassword;
	public $lastVisit;

	function __clone()
	{
		$this->id = clone $this->id;
		$this->userName = clone $this->userName;
		$this->userPassword = clone $this->userPassword;
		$this->lastVisit = clone $this->lastVisit;
	}

	public static function GetById($id)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from editors where id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$editor = new Editor;
		$stmt->bind_result($editor->id, $editor->userName, $editor->userPassword, 
			$editor->lastVisit);

		if ($stmt->fetch())
		{
			return $editor;
		}
		else 
		{
			return null;
		}
	}

	public static function GetByUserName($userName)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from editors where user_name = ?");
		$stmt->bind_param("s", $userName);
		$stmt->execute();

		$editor = new Editor;
		$stmt->bind_result($editor->id, $editor->userName, $editor->userPassword, 
			$editor->lastVisit);
		
		if ($stmt->fetch())
		{
			return $editor;
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
			$stmt = $dbconn->prepare("insert into editors (user_name, user_password,
				last_visit) values (?, ?, ?)");
			$stmt->bind_param("sss", $this->userName, $this->userPassword, $this->lastVisit);

			return $stmt->execute();
		}
		else
		{
			$stmt = $dbconn->prepare("update editors set user_name = ?, user_password = ?, 
				last_visit = ? where id = ?");
			$stmt->bind_param("sssi", $this->userName, $this->userPassword, $this->lastVisit, 
				$this->id);

			return $stmt->execute();
		}
	}
}
?>