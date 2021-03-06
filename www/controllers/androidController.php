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
                                case 'sendPins':
                                    return $this->sendPins();
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
		return json_encode(array('buildingList' => $stmt->get_result()->fetch_all(MYSQLI_ASSOC)));
	}

	// /android/map
	public function map()
    {  
     	$name = NULL;           
        $floor = NULL;  
        
        //sprawdza czy podano name i floor i zwraca potrzebne dane
        if(isset($_GET['name']) && isset($_GET['floor']))
        {
            $name = $_GET['name'];
            $floor = $_GET['floor'];
            
            $dbconn = new DatabaseConnect;
            $stmt = $dbconn->prepare("select m.id, b.name, m.floor, m.image, m.image_width, m.image_height, m.image_md5 from maps m left join buildings b on m.building_id = b.id where b.name=? and m.floor=?");
            $stmt->bind_param("si",$name,$floor);
            $stmt->execute();
            
            header('Content-Type: application/json');
            return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
        }
        
        //jesli nie podano floor zwraca wszystkie mapki
        if(isset($_GET['name']))
        {
            $name = $_GET['name'];
            
            $dbconn = new DatabaseConnect;
            $stmt = $dbconn->prepare("select * from maps left join buildings on maps.building_id = buildings.id where buildings.name=?" );
            $stmt->bind_param("s",$name);
            $stmt->execute();
            
            header('Content-Type: application/json');
            return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
        }
    }
    
        public function sendPins()
       {
           $name = NULL;           
           $floor = NULL;  
           $pinName = NULL;
        
        //sprawdza czy podano name i floor i zwraca piny
        if(isset($_GET['name']) && isset($_GET['floor']))
        {
            $name = $_GET['name'];
            $floor = $_GET['floor'];
            
            $dbconn = new DatabaseConnect;
            $stmt = $dbconn->prepare("select p.id, p.name, p.pos_x, p.pos_y from pins p inner join maps m on p.map_id = m.id inner join buildings b on m.building_id = b.id where b.name=? and m.floor=?");
            $stmt->bind_param("si",$name,$floor);
            $stmt->execute();
            
            header('Content-Type: application/json');
            return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
        }
        
        //jesli nie podano floor zwraca wszystkie pimy budynku
        if(isset($_GET['name']))
        {
            $name = $_GET['name'];
            
            $dbconn = new DatabaseConnect;
            $stmt = $dbconn->prepare("select p.id, p.name, p.map_id, p.pos_x, p.pos_y from pins inner join maps on pins.map_id = maps.id inner join buildings on maps.building_id = buildings.id where buildings.name=?" );
            $stmt->bind_param("s",$name);
            $stmt->execute();
            
            header('Content-Type: application/json');
            return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
        }
        
        //zwracanie pojedynczego pinu po nazwie
        if(isset($_GET['pinName']))
        {
            $pinName = $_GET['pinName'];
            
            $dbconn = new DatabaseConnect;
            $stmt = $dbconn->prepare("select * from pins p where p.name=?" );
            $stmt->bind_param("s",$pinName);
            $stmt->execute();
            
            header('Content-Type: application/json');
            return json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
        }
       }
}

?>