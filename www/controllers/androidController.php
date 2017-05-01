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

				case 'map':
					return $this->map();
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

	// /android/map
	public function map()
    {  
     	$name = NULL;           
        $floor = NULL;  
        
        //sprawdza czy podano name i floor i zwraca potrzebne dane
        if(isset($_POST['name']) && isset($_POST['floor']))
        {
            $name = $_POST['name'];
            $floor = $_POST['floor'];
            
            $dbconn = new DatabaseConnect;
            $stmt = $dbconn->prepare("select m.id, b.name, m.floor, m.image, m.image_width, m.image_height, m.image_md5 from maps m left join buildings b on m.building_id = b.id where b.name=? and m.floor=?");
            $stmt->bind_param("si",$name,$floor);
            $stmt->execute();
            
            header('Content-Type: application/json');
            return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
        }
        
        //jesli nie podano floor zwraca wszystkie mapki
        if(isset($_POST['name']))
        {
            $name = $_POST['name'];
            
            $dbconn = new DatabaseConnect;
            $stmt = $dbconn->prepare("select * from maps left join buildings on maps.building_id = buildings.id where buildings.name=?" );
            $stmt->bind_param("s",$name);
            $stmt->execute();
            
            header('Content-Type: application/json');
            return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
        }
    }
}

?>