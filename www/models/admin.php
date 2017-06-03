<?php
require_once 'utils/databaseConnect.php';

class Admin
{
	public $id = null;
	public $userName;
	public $userPassword;
	public $lastVisit;
	
	public static function GetById($id)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from admins where id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$admin = new Admin;
		$stmt->bind_result($admin->id, $admin->userName, $admin->userPassword, 
			$admin->lastVisit);

		if ($stmt->fetch())
		{
			return $admin;
		}
		else 
		{
			return null;
		}
	}

	public static function GetByUserName($userName)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from admins where user_name = ?");
		$stmt->bind_param("s", $userName);
		$stmt->execute();

		$admin = new Admin;
		$stmt->bind_result($admin->id, $admin->userName, $admin->userPassword, 
			$admin->lastVisit);
		
		if ($stmt->fetch())
		{
			return $admin;
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
			$stmt = $dbconn->prepare("insert into admins (user_name, user_password,
				last_visit) values (?, ?, ?)");
			$stmt->bind_param("sss", $this->userName, $this->userPassword, $this->lastVisit);

			if ($stmt->execute())
			{
				$this->id = $stmt->insert_id;
				return TRUE;
			}
			return FALSE;
		}
		else
		{
			$stmt = $dbconn->prepare("update admins set user_name = ?, user_password = ?, 
				last_visit = ? where id = ?");
			$stmt->bind_param("sssi", $this->userName, $this->userPassword, $this->lastVisit, 
				$this->id);

			return $stmt->execute();
		}
	}
}
?>