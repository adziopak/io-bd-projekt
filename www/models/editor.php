<?php
require_once 'utils/databaseConnect.php';

class Editor
{
	public $id;
	public $userName;
	public $userPassword;
	public $lastVisit;

	public static function GetEditorById($id)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from `editors` where id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$editor = new Editor;
		$stmt->bind_result($editor->id, $editor->userName, $editor->userPassword, 
			$editor->lastVisit);
		$stmt->fetch();

		return $editor;
	}

	public static function GetEditorByUserName($userName)
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from `editors` where user_name = ?");
		$stmt->bind_param("s", $userName);
		$stmt->execute();

		$editor = new Editor;
		$stmt->bind_result($editor->id, $editor->userName, $editor->userPassword, 
			$editor->lastVisit);
		$stmt->fetch();

		return $editor;
	}
}
?>