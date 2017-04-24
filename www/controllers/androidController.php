<?php

// staramy sie unikac zapytan do bazy z poziomu kontrolera
// w tym przypadku tak bedzie latwiej
require_once 'utils/databaseConnect.php';

// Obsluga zapytan dla aplikacji android
// /android
class AndroidController
{
	// /android
	public function index()
	{
		// przekierowania do akcji kontrolera
		if (isset($_GET['action']))
		{
			switch($_GET['action'])
			{
				case 'buildingList':
					return $this->buildingList();
			}
		}

		// kod /android/index
		// ...
	}

	// /android/buildingList
	public function buildingList()
	{
		$dbconn = new DatabaseConnect;
		$stmt = $dbconn->prepare("select * from buildings");
		$stmt->execute();


		header('Content-Type: application/json');
		return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
	}
}

?>