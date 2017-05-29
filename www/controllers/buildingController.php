<?php
require_once 'models/building.php';
require_once 'models/map.php';
require_once 'models/pin.php';
require_once 'models/buildingFloor.php';
require_once 'models/pathCoords.php';
require_once 'views/building/showView.php';
require_once 'views/building/chooseView.php';
require_once 'views/building/PinListView.php';

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
		header("Location: /building/choose");
		die();
	}	

	// /building/about
	public function show()
	{
		if (!isset($_GET['name']) || !isset($_GET['floor']))
		{
			header("Location: /building/choose");
			die();
		}

		$building = Building::GetByName($_GET['name']);
		$map = $building->getMap($_GET['floor']);
		$view = new BuildingShowView;
		$view->map = $map;

		if (isset($_GET['pinId']))
		{
			if (!$map->isPinIdOnMap($_GET['pinId']))
			{
				header("Location: /building/choose");
				die();
			}

			$view->pins[] = Pin::GetById($_GET['pinId']);
		}
		else
		{
			$view->pins = $map->getPinsWithName();
			$view->paths = PathCoords::GetAllFromMapId($map->id);
		}

		return $view->render();
	}

	// /building/search
	public function search()
	{
		if (isset($_GET['roomName']))
		{
			$resultPin = Pin::GetByName($_GET['roomName']);
			
			if (!is_null($resultPin))
			{
				if(count($resultPin) > 1)
				{
					$list = new PinListView;
					$list->pins = $resultPin;
					return $list->render();
				}
				
				$resultMap = Map::GetById($resultPin[0]->mapId);
				$building = Building::GetById($resultMap->buildingId);
				
				header("Location: show?name=" . $building->name . "&floor=" . $resultMap->floor . 
					"&pinId=" . $resultPin[0]->id);
				die();
			}
		}
		$view = new PinSearchView;
		return $view->render();
	}

	// /building/choose
	public function choose()
	{
		$view = new BuildingChooseView;
		$view->floors = BuildingFloor::GetAll();
		return $view->render();
	}
}

?>
