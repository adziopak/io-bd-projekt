<?php
require_once 'views/pinSearchView.php';
require_once 'utils/databaseConnect.php';
require_once 'utils/point2D.php';
require_once 'controllers/adminPanelController.php';
require_once 'controllers/androidController.php';
require_once 'controllers/homeController.php';
require_once 'controllers/buildingController.php';
require_once 'controllers/mapController.php';

require_once 'models/editor.php';

function main()
{
	session_start();

	if (!isset($_GET['path']))
	{
		$_GET['path'] = 'home';
	}

	switch ($_GET['path'])
	{
		// Kod ktory trzeba przeniesc do kontrolerow
		case 'map':
			$ctrl = new MapController;

			echo $ctrl->index();
			break;

		case 'building':
			$ctrl = new BuildingController;
			
			echo $ctrl->index();
			break;

		case 'pinSearch':
			if (isset($_GET['roomName']))
			{
				$dbconn = new DatabaseConnect;
				$sql = "select * from pins where name ='" . $_GET['roomName'] . "'";
				$resultPin = $dbconn->getConnection()->query($sql);
				$resultPin = $resultPin->fetch_assoc();
				
				if (!is_null($resultPin))
				{
					$sql = "select buildings.name, maps.floor from maps inner join buildings on maps.building_id = buildings.id where maps.id = " . $resultPin['map_id'];
					$resultMap = $dbconn->getConnection()->query($sql);
					$resultMap = $resultMap->fetch_assoc();

					header("Location: building/show?name=" . $resultMap['name'] . "&floor=" . $resultMap['floor'] . "&pinId=" . $resultPin['id']);
					die();
				}
			}

			$view = new PinSearchView;
			echo $view->render();
			break;
		
		// Tak ma to wygladac w przyszlosci
		case 'android':
			$ctrl = new AndroidController;
			
			echo $ctrl->index();
			break;

		case 'adminPanel':
			$ctrl = new AdminPanelController;

			echo $ctrl->index();
			break;

		case 'home':
			$ctrl = new HomeController;

			echo $ctrl->index();
			break;

		default:
			http_response_code(404);
			die();
	}
}

main();

?>