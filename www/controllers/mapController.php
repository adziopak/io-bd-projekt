<?php
require_once 'views/map/showView.php';
require_once 'models/building.php';

// Obsluga wyswietlania mapy wszystkich budynkow (google map i/albo nasz mapa)
// /map
class MapController
{
	// /map
	public function index()
	{
		// przekierowania do akcji kontrolera
		if (isset($_GET['action']))
		{
			switch($_GET['action'])
			{
				case 'show':
					return $this->show();
			}
		}

		header("Location: /map/show");
		die();
	}	

	// /map/show
	public function show()
	{
		$view = new MapShowView;
		$view->buildings = Building::GetAll();

		return $view->render();
	}
}

?>