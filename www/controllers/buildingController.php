<?php
require_once 'models/building.php';
require_once 'models/map.php';
require_once 'models/pin.php';
require_once 'views/building/showView.php';

// Obsluga strony z widokiem budynku, pinow i sciezek
// /building
class BuildingController
{
	// /building
	public function index()
	{
		// przekierowania do akcji kontrolera
		if (isset($_GET['action']))
		{
			switch($_GET['action'])
			{
				case 'show':
					return $this->show();

				case 'search':
					return $this->search();

				case 'choose':
					return $this->choose();
			}
		}

		// kod /building/index
		// ...
	}	

	// /building/about
	public function show()
	{
		if (!isset($_GET['name']) || !isset($_GET['floor']))
		{
			header("Location: building/choose");
			die();
		}

		$building = Building::GetByName($_GET['name']);
		$map = $building->getMap($_GET['floor']);
		$view = new BuildingShowView;
		$view->map = $map;
		$view->pins = $map->getPins();

		return $view->render();
	}

	// /building/search
	public function search()
	{

	}

	// /building/choose
	public function choose()
	{

	}
}

?>