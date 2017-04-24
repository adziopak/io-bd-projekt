<?php
require_once 'views/mapView.php';
require_once 'views/buildingView.php';
require_once 'views/pinSearchView.php';
require_once 'utils/databaseConnect.php';
require_once 'utils/point2D.php';
require_once 'controllers/adminPanelController.php';
require_once 'controllers/androidController.php';
require_once 'controllers/homeController.php';

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
			$view = new MapView;
			// TODO: wrzucic to do jakiegos configu
			$view->apiKey = "AIzaSyBcwERVsQ9-u3vGi93armuqOI4lts5qqt4";
			echo $view->render();
			break;

		case 'building':
			$dbconn = new DatabaseConnect;
			$view = new BuildingView;

			$sql = "select buildings.name, maps.floor from maps left join buildings on maps.building_id = buildings.id";
			$result = $dbconn->getConnection()->query($sql);
			$view->maps = json_encode($result->fetch_all($resulttype = MYSQLI_ASSOC));
			
			if (isset($_GET['building']))
			{

				$sql = "select maps.id, maps.image_width, maps.image_height, maps.image from buildings inner join maps on buildings.id = maps.building_id where buildings.name ='" . $_GET['building'] . "' and maps.floor ='" . $_GET['floor'] . "'";
				$result = $dbconn->getConnection()->query($sql);
				$result = $result->fetch_assoc();
				$view->currentMap = "media/" . $result['image'];
				$view->mapWidth = $result['image_width'];
				$view->mapHeight = $result['image_height'];

				$sql = "select * from pins where map_id = " . $result['id'];	

				if (isset($_GET['roomOnly']))
				{
					$sql = $sql . " and not (name is null or name = '')";
				}
				
				if (isset($_GET['pinId']))
				{
					$sql = $sql . " and id = " . $_GET['pinId'];
				}			
				
				
				$resultFetch = $dbconn->getConnection()->query($sql);

				for ($pin = $resultFetch->fetch_assoc(); $pin != null; $pin = $resultFetch->fetch_assoc())
				{
					$pos = new Point2D;
					$pos->x = $pin['pos_x'];
					$pos->y = $pin['pos_y'];
					array_push($view->positions, $pos);
				}
			}

			echo $view->render();
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

					header("Location: buildingMap?building=" . $resultMap['name'] . "&floor=" . $resultMap['floor'] . "&pinId=" . $resultPin['id']);
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